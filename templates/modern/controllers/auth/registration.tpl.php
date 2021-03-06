<?php $this->setPageTitle(LANG_REGISTRATION); ?>

<?php $this->addBreadcrumb(LANG_REGISTRATION); ?>

<h1 class="mb-4"><?php echo LANG_REGISTRATION; ?></h1>

<?php if (!$this->controller->options['is_reg_enabled']){ ?>

    <p class="alert alert-warning my-3 my-md-4"><?php echo $this->controller->options['reg_reason']; ?></p>
    <?php return; ?>

<?php } ?>

<?php
    $this->renderForm($form, $user, array(
        'action' => href_to('auth', 'register'),
        'method' => 'post',
        'submit' => array(
            'title' => LANG_CONTINUE
        )
    ), $errors);
?>
<?php ob_start(); ?>
<script>

    function toggleGroups(){

        var group_id = $('select#group_id').val();

        $('.groups-limit').hide().find('input, select, textarea').prop('required', false);

        $('.group-' + group_id).show();

        $('fieldset').each(function(){
           if ($('.field:visible', $(this)).length === 0) {
               $(this).hide();
           }
           if ($('.group-' + group_id, $(this)).length>0) {
               $(this).show();
           }
        });
    }

    $(function(){
        if ($('select#group_id').length === 0){ return false; }
        $('select#group_id').on('change', function(){ toggleGroups(); }).triggerHandler('change');
    });

</script>
<?php $this->addBottom(ob_get_clean()); ?>