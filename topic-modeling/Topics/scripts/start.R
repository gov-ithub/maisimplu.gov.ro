time.start <- proc.time()

print(proc.time() - time.start)

source("require.R")
source("topicModel.R")
source("configure.R")

print(proc.time() - time.start)


ldaVisPrepare()


print(proc.time() - time.start)
