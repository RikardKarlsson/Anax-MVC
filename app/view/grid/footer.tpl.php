
<footer >
    <span class='sitefooter navbar'>
        <a class='button button--smaller' href='http://rikardkarlsson.se'>© Rikard Karlsson</a> 
        <a class='button button--smaller' href='https://github.com/RikardKarlsson/Anax-MVC'>GitHub</a> 

        <a class='button button--smaller' href="http://validator.w3.org/check/referer">HTML5</a>
        <a class='button button--smaller' href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
        <a class='button button--smaller' href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS3</a>
        <a class='button button--smaller' href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a>
<!--
        <a class='button button--smaller' href="http://validator.w3.org/i18n-checker/check?uri=<?=getCurrentUrl()?>">i18n</a>
        <a class='button button--smaller' href="http://validator.w3.org/checklink?uri=<?=getCurrentUrl()?>">Links</a>
-->    
        <a class='button button--smaller' href="http://validator.w3.org/i18n-checker/check?uri=<?=$this->request->getCurrentUrl(); ?>">i18n</a>
        <a class='button button--smaller' href="http://validator.w3.org/checklink?uri=<?=$this->request->getCurrentUrl(); ?>">Links</a>
    

    </span>
</footer>
