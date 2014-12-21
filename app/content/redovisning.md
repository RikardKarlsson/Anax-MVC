
 
1. PHP MVC ramverk     {#kmom01}
==================
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

#Problem med Anax-MVC
##Hade inte hittat `theme/anax-base/index.tpl.php`
För att kunna stila sidan på önskat sätt behövde jag få in 
menyn i `header`, så var det inte från början.
Först efter ett [inlägg på forumet](http://dbwebb.se/forum/viewtopic.php?f=40&t=2643&sid=b668d6a56276036fafb1b13b8bfb5e11#p22802)
hittade
jag `theme/anax-base/index.tpl.php`. Sedan var det bara att ändra i filen,
så var problemt löst. Egentligen hade det räckt att läsa om artikeln om Anax-MVC.
Sökt information finns där.

##Ett mellanslag för mycket
Följande kod gav ingen stilning vid hovring.

    .navbar a: hover

Felet är att det är mellanslag mellan `a:` och `hover`.

##Vald sida i menyn stilas ej
Klassen selected sattes ej på li-taggen i menyn för index.php, 
[se forum](http://dbwebb.se/forum/viewtopic.php?f=40&t=2818&p=22990#p22990).
Direkt efter att jag postat i forumet testade jag en sista idé. 

    I navbar_me.php under 'home' sätts 'url' till '' istället för till 'index.php'.

Sedan sattes klassen, och därmed stilades valt menyalternativ som det var tänkt.

##current url
Jag lade till länkar till bl.a. i18n. Då behövdes sidans url. Jag kopierade
funktionen `getCurrentUrl()` från Anax-base och lade den i `src/functions.php`.
Finns det redan inbyggt i Anax-MVC?

#Extrauppgifter
##Dice
Jag önskade att url:en skulle vara

    webroot/kasta-tarning

Det innebar att jag fick lägga till sidan i `webroot/index.php`.
Istället för att göra en klass `CDiceController` med en metod
`getHtml()` som kan användas i `index.php`, så kopierade jag
`dice.php` från `webroot` till `webroot/incl` och gjorde några ändringar
i `dice.php`. Sedan använde jag `include` för att få in `dice.php` i 
`index.php`.
 
##Tärningsspelet 100
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

##Kalender
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

2. Kontroller och modeller {#kmom02}
===========================
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

##Mitt kommentarssystem

Mitt kommentarssystem ligger på adresserna

* ''
* 'redovisning'
* 'comment'

Nedan beskriver jag hur långt jag har kommit.
Formuläret för editering av kommentarer visas bara om `$_GET['show']` satts till 'yes'.
För att välja vilken kommentar som ska editeras eller tas bort används `$_GET['id']`.
Ett id, *#comments*, används i HTML-koden, för att man ska se kommentarerna, 
då sidan ladds om. `$_GET` används i ovanstående fall för att de ska finnas kvar vid
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
På knappen sätts `$_GET['show']` till 'yes' på samma sätt som på knappen *Edit id 2*, 
som används för att välja att den kommentaren ska editeras.

Formuläret innehåller det som fanns från början. Några knappar har dock lagts till.
Knapparna är:

* Save, för att spara.

* Cancel, för att gömma formuläret utan att spara.

* Reset, för att återställa formuläret.

* Remove all, för att ta bort alla kommentarer.

Då man editera ett formulär finns även knappen *Remove*.

##Klassen CommentsInSession
I klassen CommentsInSession har jag lagt till ett fält $sessionKey.
Det är nyckel i `$_SESSION` för kommentarerna på en sida. 
Alla kommentarer på en sida har samma nyckel.
Fältet sätts i konstruktorn. 
Med ett fält finns informationen på ett ställe och koden blir därmed
lättare att underhålla.

Objekt av klassen CommentsInSession skapas i CommentController.
Där skickas sidans namn, t.ex. '' och  'redovisning', 
med som parameter i `$_POST`, från formuläret. 
Sedan skapas nyckeln till `$_SESSION` enligt mönstret
'comments_in_sidans_namn', t.ex. 'comments_in_redovisning'.
Här finns det behov av en enhetlig namngiving för hela webbplatsen,
så att inte samma nyckel till `$_SESSION` används på flera ställen.

I CommentsInSession har metoder lagts till för att man ska kunna
ändra på en kommentar och för att man ska kunna ta bort en kommentar.

##Klassen CommentController. 
För att minimera koden som behövs för att inkludera kommentarssystemet
på en sida i frontkontrollern, *index.php*, så har koden

    $app->views-add(...

flyttats till klassen CommentController.
Vid flyten fick `$app` bytas mot `$this`.

Följande metoder är nya

    editAction()
    
    removeAction()

Dessa metoder läser id för kommentaren från `$_GET`.
Fördelen med att använda `$_GET` jämfört med, en parameter till metoden,
eller `$_POST`, är att `$_GET` följer med vid en *redirect*. Se koden nedan.

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

I `viewAction()` filtreras den data i `$_SESSION` som kommer från en inmatning
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
Det är lättare att skriva en vektor till `$_SESSION` än att serialisera ett objekt.
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

3. Bygg ett eget tema {#kmom03}
====================

Ända sedan jag började koda hemsidor 2013 har jag saknat möjligheten att programmera i 
stildokumentet (CSS). LESS ger viss möjlighet till detta. Jag har en känsla av att LESS
inte är tillräckligt kraftfullt.
Jag behöver dock öva lite mer på mixins för att testa gränserna.
Därtill gillar jag att *lessphp* körs på servern istället för på klienten.

Jag försöker skriva CSS enligt
[Scalable and Modular Architecture for CSS (SMACSS)](http://smacss.com).
I SMACSS ingår normalisering av CSS (CSS reset).
Jag har användt en väldigt enkel tidigare.
[Normalize](http://necolas.github.io/normalize.css/) 
har ett större omfång. Det är bra att bli så oberoende av vilken
webbläsare, som besökaren använder, som möjligt.

Jag gillar horisontell grid. Det ger ordning och reda.
idigare har jag använt en sidbredd på 960 pixlar och gjort 12 
kolumner på mitt eget vis. 
Mitt sätt är tyvärr inte kompatibelt med [Semantic.gs](http://semantic.gs).
[Semantic.gs](http://semantic.gs) är mer genomtänkt.

Typografi kan göra en sida mer estetiskt tilltalande. 
Det gör vertikalt rutnät viktigt.
Jag ville ha en radhöjd på 24 pixlar itället för 22, som var standard i övningen från början.
Anledningen till att 24 är bättre än 22 är att 24 kan faktoriseras på fler sätt än 22. 

    24 = 2 * 2 * 2 * 3
    22 = 2 * 11

Det gör att det finns fler möjligheter att leka med bakgrundsbilder som följder rutnätet.
Under fliken [Rikard Karlsson](me) har jag cirklar med diametern 8 pixlar i bakgrunden. 
Resultatet blir att det går precis 3 cirklar på höjden och 10 cirklar på bredden i en 
ruta som är 24 gånger 80 pixlar. Cirklarna fås genom att en klass sätts i 
[webroot/index.php](source?path=webroot/index.php).

    $app->router->add('', function() use ($app) {
        $app->theme->addClassAttributeFor("html", "html--circle");

Metoden addClassAttributeFor() är implementerad i 
[src/ThemeEngine/CThemeBasic.php](source?path=src/ThemeEngine/CThemeBasic.php)

    public function addClassAttributeFor($element, $classes = null)
    {
        if ($classes != null)
        {
            $this->config['data']['style_classes'][$element][] = $classes;
        }       
    }

Motsvarande get-metod används i 
[index.tpl.php](source?path=theme/anax-grid/index.tpl.php) för att sätta CSS-klasserna på taggarna.
[Jag fick lite hjälp på forumet.](http://dbwebb.se/forum/viewtopic.php?f=40&t=3293#p27475)

    public function getClassAttributeFor($element, $classes = null)
    {
        if ( isset($_GET['grid-on']) && $element == 'body') {
            $classes = $classes . 'grid-on ';
        }
        //$classes = $classes . " ";
        if ( isset($this->config['data']['style_classes'][$element])) {
            if (is_array($this->config['data']['style_classes'][$element])) {
                foreach ($this->config['data']['style_classes'][$element] as $class) {
                    $classes = $classes . " " . $class;
                }            
            }           
        }
        else { //no classes set
            if ($classes == null) {
                return "";
            }
        }       
        return "class ='" . $classes . "'";
    }

I funktionen ovan finns lösningen som gör att rutnätet visas på webbsidan då url:en
utökas med

    ?grid-on

Rutnätet är diskret för att smälta in.


För att lägga till sidans url som en CSS-klass på html-taggen används anropet

    $this->request->getRouteAsCssClass()

i index.tpl.php. Den anropade metoden implementeras i Request/CRequestBasic.php.

    public function getRouteAsCssClass()
    {
        return "url--" . str_replace("/", "--", $this->route);
        //return str_replace("/", "--", $this->route);
    }

Det gör att olika sidor kan stilas olika.

I [theme.less](source?path=webroot/css/anax-grid/theme.less) har jag samlat kod för bakgrundsbilder och färgsättning.
Hexagoner i bakgrunden är default. 
Temat för hela webbplatsen kan enkelt bytas i 
[app/config/theme-grid.php](source?path=app/config/theme-grid.php). Under 'data' sätts

    'style_classes' => ['html' => ['html--circle'],],

De flesta problemen men att få texten att följa raderna har jag löst.
Till exempel i Font Awesome, gav förstorade ikoner en radhöjd som ej passade med 
det vertikala rutnätet.

Lösningen bestod i att lägga till `line-height` i 
[font-awesome-4.2.0/less/lager.less](source?path=webroot/css/anax-grid/font-awesome-4.2.0/less/larger.less). Se exempel nedan.

    .@{fa-css-prefix}-2x { 
      font-size: 2em; 
      line-height: @magicNumber * 2;
    }

Ett problem är dock olöst. När code-taggar används i p-taggar blir
radhöjden en aning för stor.

Då man ska lära sig är det bra att kolla på goda exempel. 
Jag ser Bootstrap som ett sådant. Mycket återstår dock att utforska.

Jag har valt att minska på rubrikstorlekarna för att den inte ska bli så skrikiga.
Kanske gick jag lite för långt.

Jag har valt att använda alla regioner som fanns i guiden. 
Det fanns dock ett problem som jag såg det.
Till höger om main låg alltid en sidebar. 
Det gjorde att källkoden visades på 8 kolumner istället för på 12 som den borde,
för att långa kodrader ska kunna visas på ett bra sätt.

Jag valde att lösa det genom att lägga en aside på vardera sida om main. 
Om en aside saknar innehåll tar main upp all plats.

    1. left sidebar (4 kolumner) + main (8 kolumner)
    2. main (8 kolumner) + right sidebar (4 kolumner)
    3. left sidebar (3 kolumner) + main (6 kolumner) + right sidebar (3 kolumner)
    4. bara main (12 kolumner)

De olika layouterna prövas under olika flikar, se listan nedan.

1. Reg left + main
2. Redovisning och Reg main + right
3. Rikard Karlsson och Regioner
4. Kommentarer

För att testa rutnätet och för att öva på att använda regionerna, 
skrev jag om sidan med presentation av mig själv och på redovisningssidan lade jag till en meny.

LESS medförde att kalendern stilas felaktigt: framåt, bakåt och 
månadens bild hamnar på var sin rad istället för på samma rad.
Filen normalize.less medförde att stilen  för kalendern förstördes ännu mer:
bl.a. rutnät, månar, färgade datum, röda söndagar försvann.
Jag valde att ta bort kalendern från me-sidan. Det är ett ganska omfattande arbete att 
få det rätt igen. Speciellt om sidan ska vara responsiv också. Tärningspelet har jag 
också tagit bort av liknande skäl. Kommentarssidan följer ej vertikalt rutnät. 

I CSS är det omöjligt att välja ett element som föregår ett annat. 
För att kunna göra detta val lade jag till en gömd div före divarna för vänster sidebar,
main och höger sidebar. Då bara höger sidbar visas med main diven till med 
sidebar--only-right--fix som id. Då båda vänster och höger sidebar visas läggs en 
div med sidebar--both--fix som id till. Sedan väljs taggarna på följande vis i 
[responsive.less](source?path=webroot/css/anax-grid/responsive.less).

    //exactly one sidebar present
    //default
    #sidebar--left,
    #sidebar--right 

    //exactly one sidebar present
    #sidebar--left + #main,
    #sidebar--only-right--fix + #main 

    //both sidebars are present
    #sidebar--both--fix + #sidebar--left + #main 

    #sidebar--both--fix + #sidebar--left,
    #sidebar--both--fix + #sidebar--left + #main + #sidebar--right

Då sidan gjordes responsiv flyttades kolumnhanteringen från structure.less till responsive.less.
För att få så god kontroll över bredderna för regionerna som möjligt valde jag att 
ha tre fasta bredder: 480, 640 och 960 pixlar. 
Det motsvarar 6, 8 respektive 12 kolumner på 80 pixlar. 
Om jag skulle göra om det skulle jag ha valt bort en av de smalaste och lagt till en som
var anpassad för en skärm på en stationär dator, t.ex. 16 kolumner á 80 pixlar.
Då skärmbredden är 480 pixlar läggs alla regioner under varandra.
Då skärmbredden är 640 pixlar läggs regionerna på följnade vis:

    flash (8 kolumner)
    featured-1 (4) + featured-2 (4)
    featured-3 (4) + 4 tomma kolumner, featured-3 skulle enkelt kunna gömmas
    sidebar--left (3) + main (5)
    sidebar--right (3) + 5 tomma kolumner
    triptych-1 (4) + triptych-2 (4)
    triptyck-3 (4) + 4 tomma kolumner
    footer-col-1 (4) + footer-col-2 (4)
    footer-col-3 (4) + footer-col-4 (4)

I responsiv.less gjorde följande kod att kolumnbredden blev fel

    .column(@columns *3 / 8); 

Lösningen var att sätta in mellanslag mellan * och 3. 
Jag tycker inte om att man inte kan skriva *3 utan mellanslag. Det borde gå.
Sedan är det en annan sak att man ändå bör skriva med mellanslag för att det är mer läsbart.

När jag lagt upp koden på studentservern blev det problem med att sidan inte stilades.
Lösningen hittade jag på [forumet](http://dbwebb.se/forum/viewtopic.php?f=40&t=3322&p=27896&hilit=LESS+studentservern#p27484). 
Den bestod i att sätta filrättigheterna till 777 
på mappen webroot/css/anax-grid och 
att ta bort style.css och style.less.cache.















