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

2. Kontroller och modeller
-------------------------
Jag gjorde hela kursen oophp utan att förstå hur användbart Markdown är.
Nu vill jag aldrig mer vara utan ett så användbart verktyg för att
formatera texter för webben.

Jag följde guiden för Composer. Det fungerade relativt smärtfritt.

På Packagist har jag hittat ett flertal paket som verkar intressanta.
Några listas nedan. Inga paket har dock installerats än.
Först behöver de granskas lite närmare.

*  [Symfony Form Component](https://packagist.org/packages/symfony/form)

*  [Client library for Google APIs](https://packagist.org/packages/google/apiclient) Finns kanske API för youtube. Jag fuskade på examinationsuppgiften för kursen oophp, och använde inte Googles API för film.

*  [phpdocumentor/reflection-docblock](https://packagist.org/packages/phpdocumentor/reflection-docblock) Att skapa dokumentation är alltid användbart.

*  [Allows you to easily serialize, and deserialize data of any complexity](https://packagist.org/packages/jms/serializer-bundle) Jag serialiserar objekt i mitt tärningsspel. Kan man förenkla detta så är det användbart. När objekt ligger i objekt är det en utmaning att få det rätt vid första försöket.

*  [General-Purpose Collection Library for PHP](https://packagist.org/packages/phpcollection/phpcollection) Jag är van vid att använda kollektioner i Java. Jag har saknat detta i PHP. Jag antar att det till viss del beror på att vektorerna i PHP är väldigt kraftfulla, då man bland annat kan namnge index (nycklar).

*  [Utility class for timing](https://packagist.org/packages/phpunit/php-timer) Tidsmätning för att söka efter flaskhalsar kan vara intressant.

*  [The PHP Unit Testing framework.](https://packagist.org/packages/phpunit/phpunit) Testdriven utveckling är intressant.

Nu till min lösning.

###Mitt kommentarssystem

Mitt kommentarssystem ligger på adresserna

* ''
* 'redovisning'
* 'comment'

Nedan beskriver jag hur långt jag har kommit.
Formuläret för editering av kommentarer visas bara om $_GET['show'] satts till 'yes'.
För att välja vilken kommentar som ska editeras eller tas bort används $_GET['id'].
Ett id, *#comments*, används i HTML-koden, för att man ska se kommentarerna, 
då sidan ladds om. $_GET används i ovanstående fall för att de ska finnas kvar vid
en *redirect*. Mer om *redirect* kommer senare.

Alla kommentarer visas alltid på sidan. I varje kommentar finns följande.

* En knapp *Edit id 2*, används för att ändra en kommentar.

* Texten filtrerad i Markdown. Texten sparas som den matas in i $_SESSION och filtreras först vid visning.

* En knapp med namnet. Den leder till angiven hemsida.

* En knapp med e-post. Den leder till förvalt mejlprogram, då den använder *mailto:* i en a-tagg.

* Datum och tid då kommentaren senast ändrades.

* En gravatar i en egen kolumn till vänster om resten.

Längst ner finns en knapp *Add comment*. 
Formuläret är gömt från start.
Klick på knappen gör att formuläret visas.
På knappen sätts $_GET['show'] till 'yes' på samma sätt som på knappen *Edit id 2*, 
som används för att välja att den kommentaren ska editeras.

Formuläret innehåller det som fanns från början. Några knappar har dock lagts till.
Knapparna är:

* Save, för att spara.

* Cancel, för att gömma formuläret utan att spara.

* Reset, för att återställa formuläret.

* Remove all, för att ta bort alla kommentarer.

Då man editera ett formulär finns även knappen *Remove*.

###Klassen CommentsInSession
I klassen CommentsInSession har jag lagt till ett fält $sessionKey.
Det är nyckel i $_SESSION för kommentarerna på en sida. 
Alla kommentarer på en sida har samma nyckel.
Fältet sätts i konstruktorn. 
Med ett fält finns informationen på ett ställe och koden blir därmed
lättare att underhålla.

Objekt av klassen CommentsInSession skapas i CommentController.
Där skickas sidans namn, t.ex. '' och  'redovisning', 
med som parameter i $_POST, från formuläret. 
Sedan skapas nyckeln till $_SESSION enligt mönstret
'comments_in_sidans_namn', t.ex. 'comments_in_redovisning'.
Här finns det behov av en enhetlig namngiving för hela webbplatsen,
så att inte samma nyckel till $_SESSION används på flera ställen.

I CommentsInSession har metoder lagts till för att man ska kunna
ändra på en kommentar och för att man ska kunna ta bort en kommentar.

###Klassen CommentController. 
För att minimera koden som behövs för att inkludera kommentarssystemet
på en sida i frontkontrollern, *index.php*, så har koden

    $app->views-add(...

flyttats till klassen CommentController.
Vid flyten fick `$app` bytas mot `$this`.

Följande metoder är nya

    editAction()
    
    removeAction()

Dessa metoder läser id för kommentaren från $_GET.
Fördelen med att använda $_GET jämfört med, en parameter till metoden,
eller $_POST, är att $_GET följer med vid en *redirect*. Se koden nedan.

    $this->response->redirect($this->request->getPost('redirect'));

Då redirect sker till sidnamnen: '', 'redovisning', och 'comment'
kan man inte skicka med *action* eller *parametrar* om man vill 
komma till frontkontrollern *index.php*. Där fångas bara sidnamnen
eftersom koden där bara är

    $app->router->add('', ...
    
    $app->router->add('redovisning', ...
    
*Redirect* används i alla metoder förutom i `viewAction($sessionKey = null)`.
Denna metod tar emot alla *redirect:s*. Som nämnt tidigar skickar sidans
namn med som en parameter till metoden `viewAction()`.

I `viewAction()` filtreras den data i $_SESSION som kommer från en inmatning
i ett formulär. Kommentarstexten filtreras med Markdown. 
Namn, epost och hemsida filtreras med `strip_tags()`.
Nu har jag gjort det jag kan för att förhindra injektioner.
Däremot filtreras inte det som skickas till formuläret för editering av innehåll.

Om jag haft mer tid skulle skapa en klass Comment. I den skulle filtreringen gömmas.
Då blir det lättare att återanvända och koden i `viewAction` blir kortare.
Ett sak i PHP som gör att jag använder vektorer istället för klasser är att
vektorer är så kraftfulla i PHP, jämfört med i Java. 
Index kan ges godtyckliga värden i PHP men inte i Java.
Men det gör att byggklossarna, klasserna, blir större. 
Det är lättare att skriva en vektor till $_SESSION än att serialisera ett objekt.
Jag behöver läsa på lite mer för att se vilka möjligheter som finns.

Det var en någorlunda detaljerad beskrivning av min lösning.
En hel del detaljer har utelämnats.

Jag har kämpat innan jag har fått insikt i hur saker och ting hänger
ihop i kommentarssystemet. Läsanvisningarna till Phalcon har var mycket givande här.
Det har blivit några inlägg i forumet också.

Då jag stilade kommentarssystemet stötte jag på en del problem. 

Ett olöst sådant följer.

I formuläret önskade jag att textrutan skulle komma till höger om ledtexten
och inte under denna. I en testfil lyckades det då jag satte
`display: inline` på taggen input. 
Jag antar att det är en kollision med en annan regel.

Övningen har varit mycket lärorik. Jag förstår allt mer hur Anax-MVC fungerar.
Läsningen i artiklarna om Phalcon var intressant och lärorik.

/Rikard


