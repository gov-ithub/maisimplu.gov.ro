### Instalare
https://mran.microsoft.com/open/

### Configurare
1. Creaza un nou fisier in scripts: `configure.R`
2. Modifica continutul fisierului
```
con = dbConnect(MySQL(),
    user = 'db user',
    password = 'db password',
    host = 'localhost',
    dbname = 'maisimplu')


wd <- "C:\\Proj\\gov-ithub\\maisimplu.gov.ro\\topic-modeling\\Topics"
setwd(wd)
```

### Adjusteaza
In acest moment dureaza 450 secunde generarea raportului pentru baza de date mai simplu. Poti micsora/mari numarul de propuneri procesate modificand n in `topicModel.R\ ... dbFetch(res, n = 10)`. 
n = -1 este nelimitat.

### Run
1. CD `C:\Proj\gov-ithub\maisimplu.gov.ro\topic-modeling\Topics\scripts` sau locatia unde este `start.R`
2. Run `"C:\Program Files\Microsoft\MRO-3.3.2\bin\Rscript.exe" --verbose start.R`

### Access 
`vis\index.html` este pagina de start si generata de comanda de mai sus. Ai nevoie de un server web sa serveasca aceasta pagina


Spor!
