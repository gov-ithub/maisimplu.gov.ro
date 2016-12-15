#load text mining library
library(tm)
library(RMySQL)
library(lda)
library(LDAvis)



readPost <- function(id) {

    query <- paste("SELECT CONCAT(p.post_content, ' ', IFNULL(GROUP_CONCAT(c.comment_content separator ' '), ' ')) as post_content
			FROM maisimplu.maisiwp_posts p
				LEFT JOIN maisiwp_comments c on c.comment_post_ID = p.ID
			WHERE p.ID = ", toString(id), " GROUP BY p.ID;")
    res <- dbSendQuery(con, query)
    data <- dbFetch(res)
    return(data)
}

ldaVisPrepare <- function() {

    res <- dbSendQuery(con,
        "SELECT ID
            FROM maisimplu.maisiwp_posts
            WHERE post_type = 'post'
				and post_status = 'publish';")
    data <- dbFetch(res, n = 10)

    dbClearResult(res)

    # colnames(data) <- c("ID", "post_title", "post_content")
    # data.df <- data.frame(data)

    #load files into corpus
    #get listing of .txt files in directory
    filenames <- data[, 1]

    #read files into a character vector
    files <- lapply(filenames, readPost)
	
    #create corpus from vector
    # docs <- Corpus(VectorSource(files), readerControl = list(language = "ro"))
    # docs <- Corpus(data.df)
    docs <- data.frame(files)
    #inspect a particular document in corpus
    # writeLines(as.character(docs[[30]]))

    #start preprocessing
    #Transform to lower case
    docs <- gsub("'", "", docs) # remove apostrophes
    docs <- gsub("[[:punct:]]", " ", docs) # replace punctuation with space
    docs <- gsub("[[:cntrl:]]", " ", docs) # replace control characters with space
    docs <- gsub("^[[:space:]]+", "", docs) # remove whitespace at beginning of documents
    docs <- gsub("[[:space:]]+$", "", docs) # remove whitespace at end of documents
    docs <- gsub('[[:digit:]]+', "", docs)
    docs <- tolower(docs) # force to lowercase

	swords <- read.table('./data/stopwords.data')
	myStopwords <- swords[, 1]
	
	doc.list <- strsplit(as.character(docs), "[[:space:]]+")

    # compute the table of terms:
    term.table <- table(unlist(doc.list))
    term.table <- sort(term.table, decreasing = TRUE)

    # remove terms that are stop words or occur fewer than 5 times:
    del <- names(term.table) %in% myStopwords | names(term.table) %in% stopwords("romanian") | term.table < 5
    term.table <- term.table[!del]
    
    # remove empty terms
    # term.table <- term.table[term.table != ""]
    vocab <- names(term.table)

    

    # now put the documents into the format required by the lda package:
    get.terms <- function(x) {
        index <- match(x, vocab)
        index <- index[!is.na(index)]
        rbind(as.integer(index - 1), as.integer(rep(1, length(index))))
    }
    documents <- lapply(doc.list, get.terms)

    # Compute some statistics related to the data set:
    D <- length(documents) # number of documents (2,000)
    W <- length(vocab) # number of terms in the vocab (14,568)
    doc.length <- sapply(documents, function(x) sum(x[2,])) # number of tokens per document [312, 288, 170, 436, 291, ...]

    N <- sum(doc.length) # total number of tokens in the data (546,827)
    term.frequency <- as.integer(term.table) # frequencies of terms in the corpus [8939, 5544, 2411, 2410, 2143, ...]

    # MCMC and model tuning parameters:
    K <- 20
    G <- 5000
    alpha <- 0.02
    eta <- 0.02

    # Fit the model:
	
    set.seed(357)
    t1 <- Sys.time()
    fit <- lda.collapsed.gibbs.sampler(documents = documents, K = K, vocab = vocab,
                                   num.iterations = G, alpha = alpha,
                                   eta = eta, initial = NULL, burnin = 0,
                                   compute.log.likelihood = TRUE)
    t2 <- Sys.time()
    print(t2 - t1) # about 24 minutes on laptop

    theta <- t(apply(fit$document_sums + alpha, 2, function(x) x / sum(x)))
    phi <- t(apply(t(fit$topics) + eta, 2, function(x) x / sum(x)))

    dataReviews <- list(phi = phi,
                     theta = theta,
                     doc.length = doc.length,
                     vocab = vocab,
                     term.frequency = term.frequency)

	# replace empty elements with -
	dataReviews$vocab <- replace(dataReviews$vocab, nchar(vocab) == 0, "-")
	
    write.csv(dataReviews$vocab, file = "./vis/TermsFreq.csv")


    # create the JSON object to feed the visualization:
    json <- createJSON(phi = dataReviews$phi,
                   theta = dataReviews$theta,
                   doc.length = dataReviews$doc.length,
                   vocab = dataReviews$vocab,
                   term.frequency = dataReviews$term.frequency)

    serVis(json, out.dir = 'vis', open.browser = FALSE)
}
