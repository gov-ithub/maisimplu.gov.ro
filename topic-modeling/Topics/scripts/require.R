requiredPackages <- c("tm", "topicmodels", "RMySQL", "LDAvis")

ipak <- function(pkg) {
    new.pkg <- pkg[!(pkg %in% installed.packages()[, "Package"])]
    if (length(new.pkg))
        install.packages(new.pkg, dependencies = TRUE)
    sapply(pkg, require, character.only = TRUE)
}

ipak(requiredPackages)

# options(encoding = "UTF-8-BOM")