<?php if(isset($aside)) : ?>
<aside class='t-left me--aside'>
<?=$aside?>
</aside>
<aside class='t-right me--aside'>
<?=$aside?>
</aside>

<?php endif; ?>
<article class="article--me">
 
<?=$content?>
 
<?php if(isset($byline)) : ?>
<footer class="byline">
<?=$byline?>
</footer>
<?php endif; ?>
 
</article>