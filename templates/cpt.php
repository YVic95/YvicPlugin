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

                $options = get_option( 'yvic_plugin_cpt' ) ?: array();
            ?>
            <table id="custom_post_type_table">
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
                    $public = ( isset($option['public']) && $option['public'] ) ? 'Yes' : 'No';
                    $archive = ( isset($option['has_archive']) && $option['has_archive'] )? 'Yes' : 'No';
            ?>
                    <tr>
                        <td><?=$option['post_type']?></td>
                        <td><?=$option['singular_name']?></td>
                        <td><?=$option['plural_name']?></td>
                        <td><?=$public?></td>
                        <td><?=$archive?></td>
                        <td>
                            <a href="#">Edit</a> /
                            
                            <!--Form for deleting custom post type from array of cpts -->

                            <form method="post" action="options.php" class="inline-block">
                                <?php
                                    settings_fields( 'yvic_plugin_cpt_settings' );
                                    ?>
                                <input type="hidden" name="remove" value="<?=$option['post_type']?>" />
                                <?php
                                    submit_button( 'Delete', 'delete small', 'submit', false, 
                                        array(
                                            'onclick' => "return confirm('Are you sure you want delete this custom post type? The data associated with it will not be deleted');"
                                    ) );
                                ?>
                            </form> 
                        
                        </td>
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