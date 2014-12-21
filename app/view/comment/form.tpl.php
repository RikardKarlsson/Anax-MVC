<div class='comment-form '>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($pageId).'#comments'?>">
        <input type=hidden name="pageId" value="<?=$pageId?>">
        <!-- <fieldset> -->
        <?php if($doShowCommentField == "true") { ?>   
        <input type='hidden' name='doShowCommentField' value='false' />
        <!-- <legend>Comment</legend> -->
        <p><label>Comment (formated using <a href='http://daringfireball.net/projects/markdown/basics'>Markdown</a>):<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name:<input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Homepage (http://www.rikardkarlsson.se):<input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <?php if($saveAction == 'doCreate') {?>
            <input class='button button--smaller' type='submit' name='doCreate' value='Save' onClick="this.form.action = '<?=$this->url->create('comment/add#comments')?>'"/>
                
            <?php }else{ ?>
            <input type='hidden' name="id" value="<?=array($id)?>">
            <input class='button button--smaller' type='submit' name='doEdit' value='Edit' onClick="this.form.action = '<?=$this->url->create('comment/edit').'?id=' . $id?>#comments'"/>
                
            <?php } ?>
            <input class='button button--smaller' type='submit' name='cancel' value='Cancel' onClick="this.form.action = '<?=$this->url->create($pageId). '#comments'?>'"/>
            
            <input class='button button--smaller' type='reset' value='Reset'/>
            <?php if ($id != null) { ?>
                <input class='button button--smaller' type='submit' name='doRemove' value='Remove' onClick="this.form.action = '<?=$this->url->create('comment/remove').'/'.$pageId.'?id=' . $id?>#comments'"/>
                
            <?php } ?>
            <input class='button button--smaller' type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?=$this->url->create('comment/remove-all#comments')?>'"/>
        </p>
        <output><?=$output?></output>
        <?php } else {  ?>
        <p>
            <input type='hidden' name='doShowCommentField' value='true' />
            <input type='hidden' name='show' value='true' />
            <input class='button button--smaller' type='submit' name='doShowAddComment' value='Add comment' onClick="this.form.action = '<?=$this->url->create($pageId . '?show=yes#comments')?>'"/>            
        </p>
        <?php } ?>
        <!-- </fieldset> -->
    </form>
</div>
