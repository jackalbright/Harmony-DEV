<div>
<? echo $ajax->form("search_ajax",'post', array('model'=>'Quote','enctype'=>'multipart/form-data','name'=>'quoteForm','class'=>'hide','id'=>'quoteForm','loaded'=>"")); ?>

<?= $form->input("keyword", array()); ?>

<?= $form->end("Search"); ?>

</div>
