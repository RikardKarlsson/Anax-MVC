Redovisning
====================================
 
1. PHP MVC ramverk
------------------------------------
Jag utvecklar i Aptana Studio 3 under Mac OS X 10.9.4, och använder MAMP, och FileZilla.
Jag testar mina sidor främst med Firefox, men ibland även med Safari, Opera, Chrome.

I kursen oophp använde jag Anax,
men annars har jag inte använt ramverk för webbutbeckling tidigare.
Jag har undervisat i objektorienterad programmering med hjälp av Java
på gymnasiet sedan 2002. Det gör att jag är väl förtrogen med den objektorienterade 
programmeringen, men resten är nytt för mig. Versionshanteringssystem har
jag dock använt tidigare, så lite av tänket vid användandet av GitHub har jag med mig.
Jag kom igång med GitHub utan större probelm.

Jag har använt det jag lärt mig i kursen
*oophp* för att utveckla [rikardkarlsson.se](http://rikardkarlsson.se/).
Huvudsidan [rikardkarlsson.se](http://rikardkarlsson.se/) följer mallen för Anax-base,
men undersidorna
[rikardkarlsson.se/fysik2/start.php](http://rikardkarlsson.se/fysik2/start.php)
o.s.v. har lagts
till efter modifiering i Anax-base. Det känns som att Anax-base inte räckt till
riktigt. Sidan har helt enkelt blivit för stor. Jag ser fram emot att få lära mig
mer om Anax-MVC. Planen är att byta från Anax-base till Anax-MVC när kursen
phpmvc är slut.

Jag har gjort samtliga extrauppgifter. Jag har tampats med både stora och små problem.
Jag redovisar ett axplock. Till de felsökningsmetoder jag använder hör att:

* skriva ut variablers värden till webbläsaren
* kolla på källkoden i webbläsaren och jämföra med önskad kod
* handköra Anax-MVC med papper och penna

Jag tror att jag skulle kunna förstå Anax-MVC bättre om jag haft tillgång till
klassdiagram, till exempel skrivna enligt UML. Jag har inte tagit mig tid till
att köra reverse engineering i till exempel [ArgoUML](http://argouml.tigris.org/).

##Problem med Anax-MVC
###Hade inte hittat `theme/anax-base/index.tpl.php`
För att kunna stila sidan på önskat sätt behövde jag få in 
menyn i `header`, så var det inte från början.
Först efter ett [inlägg på forumet](http://dbwebb.se/forum/viewtopic.php?f=40&t=2643&sid=b668d6a56276036fafb1b13b8bfb5e11#p22802)
hittade
jag `theme/anax-base/index.tpl.php`. Sedan var det bara att ändra i filen,
så var problemt löst. Egentligen hade det räckt att läsa om artikeln om Anax-MVC.
Sökt information finns där.

###Ett mellanslag för mycket
Följande kod gav ingen stilning vid hovring.

> `.navbar a: hover`

Felet är att det är mellanslag mellan `a:` och `hover`.

###Vald sida i menyn stilas ej
Klassen selected sattes ej på li-taggen i menyn för index.php, 
[se forum](http://dbwebb.se/forum/viewtopic.php?f=40&t=2818&p=22990#p22990).
Direkt efter att jag postat i forumet testade jag en sista idé. 

> `I navbar_me.php under 'home' sätts 'url' till '' istället för till 'index.php'.`

Sedan sattes klassen, och därmed stilades valt menyalternativ som det var tänkt.

###current url
Jag lade till länkar till bl.a. i18n. Då behövdes sidans url. Jag kopierade
funktionen `getCurrentUrl()` från Anax-base och lade den i `src/functions.php`.
Finns det redan inbyggt i Anax-MVC?

##Extrauppgifter
###Dice
Jag önskade att url:en skulle vara

> `webroot/kasta-tarning`

Det innebar att jag fick lägga till sidan i `webroot/index.php`.
Istället för att göra en klass `CDiceController` med en metod
`getHtml()` som kan användas i `index.php`, så kopierade jag
`dice.php` från `webroot` till `webroot/incl` och gjorde några ändringar
i `dice.php`. Sedan använde jag `include` för att få in `dice.php` i 
`index.php`.
 
###Tärningsspelet 100
Kopierade koden från `oophp`. Lade till `namespace` för att undvika
namnkollisioner. Det finns t.ex. två klasser CDice.
Efter [inlägg i forumet](http://dbwebb.se/forum/viewtopic.php?f=12&t=1304#p23631) lät jag mitt `namespace` börja med
`RikardKarlsson`. Det får vara mitt "vendor"-namn. Det finns ingen garanti för att det
är unikt men det får duga.  Jag äger rikardkarlsson.se och rikardkarlsson.com
och numera är jag RikardKarlsson på GitHub.

Sidkontrollern `dice100.php` hamnade i `webroot/incl` och inkluderas
i `index.php`, på samma sätt som för `dice.php`. Kalendern har också 
lagts till på samma vis.

I spelet skrivs objekten till $_SESSION. Det var problem innan jag insåg hur
man startar en session. Det gjorde jag i samma stund som jag postade min 
[fråga i fourmet](http://dbwebb.se/forum/viewtopic.php?f=40&t=2858).

###Kalender
Jag använde mig av koden för kalendern från kursmoment två i kursen oophp.
Jag har en annan variant av kalendern som jag utvecklat i examinationsuppgiften
på oophp. I den kan man lägga in händelser, som sparas i databas.
För att inte krångla till det valde jag den enklare vägen.
Jag vill se lite mer av hur det är tänkt att Anax-MVC ska användas, så
att jag jobbar mot databasen som det är tänkt i Anax-MVC. Därtill kräver
den senare kalendern login för att man ska kunna lägga till händelser i
kalendern.

Jag återanvänder stilningen från examinationsuppgiften istället för stilningen
från kursmoment två. Det stälde till det lite, då en del av html-koden ändrats.
Men till slut blev resultatet tillfredställande, även om det inte är perfekt.

 


