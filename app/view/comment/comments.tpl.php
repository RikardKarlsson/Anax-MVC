<?php
$email = 'mikael.roos@bth.se';
$email = 'karlsson.rikard@gmail.com';
$size = 60;
$gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg?s=' . $size;
$gravatar = getGravatarUrl($email, 60);
?>
<div class='t-center-8of12' id='comments'>
<h2>Comments</h2>
<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<!-- <h4>Edit id <?=$id?></h4> -->
<!-- <p><?=dump($comment)?></p> -->
<div class='comment t-clearfix'>
<img class='t-left' src='<?=getGravatarUrl($comment['mail'])?>' />
<div class='comment-text'>
<p><a class='button button--smaller' href='<?=$pageId?>?show=yes&id=<?=$id?>#comments'>Edit id <?=$id?></a></p>
<div>
    <?=$comment['content']?>
</div>
<p>
    <a class='button button--smaller' href='<?=$comment['web']?>'><?=$comment['name']?></a>
    <a class='button button--smaller' href='mailto:<?=$comment['mail']?>'><?=$comment['mail']?></a>
    <?= date('Y-m-d H:i:s', (float)$comment['timestamp']) ?>
</p> 
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>

