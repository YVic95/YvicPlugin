<div class="wrap">
    <h1>CPT Manager</h1>
    <?php settings_errors() ?>
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Your Custom Post Types</a></li>
        <li><a href="#tab-2">Add Custom Post Type</a></li>
        <li><a href="#tab-3">Export</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <h3>Manage your Custom Post Type</h3>  
            <!--looping array of cpt --> 
            <?php
                $options = get_option( 'yvic_plugin_cpt' );
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Singular Name</th>
                    <th>Plural Name</th>
                    <th>Public</th>
                    <th>Archive</th>
                    <th>Actions</th>
                </tr>
            
            <?php
                foreach ($options as $option) { 
            ?>
                    <tr>
                        <td><?=$option['post_type']?></td>
                        <td><?=$option['singular_name']?></td>
                        <td><?=$option['plural_name']?></td>
                        <td><?=$option['public'] ? 'Yes' : 'No'?></td>
                        <td><?=$option['has_archive'] ? 'Yes' : 'No'?></td>
                        <td><a href="#">EDIT / </a><a href="#">DELETE</a></td>
                    </tr>   
                <?php 
                    }
                ?>
            </table>
            
        </div>
        <div id="tab-2" class="tab-pane">
            
            <form method="post" action="options.php">
                <?php 
                    settings_fields( 'yvic_plugin_cpt_settings' );
                    do_settings_sections( 'yvic_plugin_cpt' );
                    submit_button();
                ?>
            </form>
        </div>
        <div id="tab-3" class="tab-pane">
            <h3>Export your Custom Post Type</h3>
        </div>
    </div>
</div>