<?php

    $this->addTplJSName([
        'datatree',
        'admin-content'
    ]);

    $this->addTplCSSName('datatree');

    $this->setPageTitle(LANG_CP_SECTION_USERS);

    $this->addBreadcrumb(LANG_CP_SECTION_USERS, $this->href_to('users'));

    if(cmsController::enabled('messages')){
        $this->addMenuItem('breadcrumb-menu', [
            'title' => LANG_CP_USER_PMAILING,
            'url' => $this->href_to('controllers', array('edit', 'messages', 'pmailing')),
            'options' => [
                'icon' => 'icon-envelope-letter'
            ]
        ]);
    }

    $this->addMenuItem('breadcrumb-menu', [
        'title' => LANG_CONFIG,
        'url' => $this->href_to('controllers', array('edit', 'users')),
        'options' => [
            'icon' => 'icon-settings'
        ]
    ]);

	$this->addToolButton(array(
		'class' => 'help',
		'title' => LANG_HELP,
		'target' => '_blank',
		'href'  => LANG_HELP_URL_USERS
	));

    $this->addToolButton(array(
        'class' => 'filter',
        'title' => LANG_FILTER,
        'href'  => null,
        'onclick' => "return icms.modal.openAjax($(this).attr('href'),{},false,$(this).attr('title'))"
    ));

    $this->addToolButton(array(
        'class' => 'delete_filter important',
        'title' => LANG_CANCEL,
        'href'  => null,
        'onclick' => "return contentCancelFilter()"
    ));

    $this->addToolButton(array(
        'class' => 'add_user',
        'title' => LANG_CP_USER_ADD,
        'href'  => $this->href_to('users', 'add')
    ));

    $this->addToolButton(array(
        'class' => 'users',
        'childs_count' => 4,
        'title' => LANG_GROUP,
        'href'  => ''
    ));

    $this->addToolButton(array(
        'class' => 'add_folder',
        'level' => 2,
        'title' => LANG_CP_USER_GROUP_ADD,
        'href'  => $this->href_to('users', 'group_add')
    ));

    $this->addToolButton(array(
        'class' => 'edit',
        'level' => 2,
        'title' => LANG_CP_USER_GROUP_EDIT,
        'href'  => $this->href_to('users', 'group_edit')
    ));

    $this->addToolButton(array(
        'class' => 'permissions',
        'level' => 2,
        'title' => LANG_CP_USER_GROUP_PERMS,
        'href'  => $this->href_to('users', 'group_perms')
    ));

    $this->addToolButton(array(
        'class' => 'delete',
        'level' => 2,
        'title' => LANG_CP_USER_GROUP_DELETE,
        'href'  => $this->href_to('users', 'group_delete'),
        'onclick' => "return confirm('".LANG_CP_USER_GROUP_DELETE_CONFIRM."')"
    ));

    $this->applyToolbarHook('admin_users_toolbar');

?>

<div class="row grid-layout align-content-around">
    <div class="col-2">
        <div class="card mb-0 h-100">
            <div id="datatree" class="card-body">
                <ul id="treeData">
                    <?php foreach($groups as $id=>$group){ ?>
                        <li id="<?php echo $group['id'];?>" class="folder"><?php echo $group['title']; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-10">
        <?php $this->renderGrid(false, $grid); ?>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(document).on('click', '.datagrid .filter_ip', function (){
            $('#filter_ip').val($(this).text()).trigger('input');
            return false;
        });
        $('.cp_toolbar .delete_filter a').hide();
        $("#datatree").dynatree({

            onPostInit: function(isReloading, isError){
                var path = $.cookie('icms[users_tree_path]');
                if (!path) { path = '/0'; }
                $("#datatree").dynatree("getTree").loadKeyPath(path, function(node, status){
                    if(status == "loaded") {
                        node.expand();
                    }else if(status == "ok") {
                        node.activate();
                        node.expand();
                        icms.datagrid.init();
                    }
                });
            },

            onActivate: function(node){
                node.expand();
                $.cookie('icms[users_tree_path]', node.getKeyPath(), {expires: 7, path: '/'});
                var key = node.data.key;
                icms.datagrid.setURL("<?php echo $this->href_to('users'); ?>/" + key);
                $('.cp_toolbar .filter a').attr('href', "<?php echo $this->href_to('users', array('filter')); ?>/" + key[0]);
                $('.cp_toolbar .add_user a').attr('href', "<?php echo $this->href_to('users', 'add'); ?>/" + key);
                if (key == 0){
                    $('.cp_toolbar .edit a').hide();
                    $('.cp_toolbar .permissions a').hide();
                    $('.cp_toolbar .delete a').hide();
                } else {
                    $('.cp_toolbar .edit a').show().attr('href', "<?php echo $this->href_to('users', 'group_edit'); ?>/" + key);
                    $('.cp_toolbar .permissions a').show().attr('href', "<?php echo $this->href_to('users', 'group_perms'); ?>/" + key);
                    $('.cp_toolbar .delete a').show().attr('href', "<?php echo $this->href_to('users', 'group_delete'); ?>/" + key + '?csrf_token='+icms.forms.getCsrfToken());
                }
                icms.datagrid.loadRows();
            }

        });
    });
</script>