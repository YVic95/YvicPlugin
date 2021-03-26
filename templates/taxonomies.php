<div class="wrap">
    <h1>Taxonomy Manager</h1>
    <?php settings_errors(); ?>
    
    <ul class="nav nav-tabs">
        <li class=" <?php echo !isset($_POST['edit_taxonomy']) && !isset($_POST['add_taxonomy'])  ? 'active' : '' ?>">
            <a href="#tab-1">
                Your Taxonomies
            </a>
        </li>
        <li class=" <?php echo isset($_POST['edit_taxonomy']) || isset($_POST['add_taxonomy']) ? 'active' : '' ?> ">
            <a href="#tab-2" >
                <?php echo isset($_POST['edit_taxonomy']) ? 'Edit' : 'Add' ?> Taxonomy
            </a>
        </li>
        <li><a href="#tab-3">Export</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST['edit_taxonomy']) && !isset($_POST['add_taxonomy']) ? 'active' : '' ?>">
            <div class="table_header">
                <h3>Manage your Taxonomy</h3> 
                <!--add taxonomy form -->
                <form method="post" action="" class="inline-block">
                    <input type="hidden" name="add_taxonomy" value="add_taxonomy" />
                    <?php
                        submit_button( 'Add New', 'primary small', 'submit', false );
                    ?>
                </form> 
            </div>
            <!--looping array of cpt --> 
            <?php

                $options = get_option( 'yvic_plugin_tax' ) ?: array();
            ?>
            <table id="taxonomy_table">
                <tr>
                    <th>ID</th>
                    <th>Singular Name</th>
                    <th>Hierarchical</th>
                    <th>Actions</th>
                </tr>
            
            <?php
                foreach ($options as $option) { 
                    //var_dump($options);
                    //die;
                    $hierarchical = ( isset($option['hierarchical']) && $option['hierarchical'] ) ? 'Yes' : 'No';
            ?>
                <tr>
                    <td><?=$option['taxonomy']?></td>
                    <td><?=$option['singular_name']?></td>
                    <td><?=$hierarchical?></td>
                    <td>
                        <!--edit taxonomy form -->
                        <form method="post" action="" class="inline-block">
                            <input type="hidden" name="edit_taxonomy" value="<?=$option['taxonomy']?>" />
                            <?php
                                submit_button( 'Edit', 'primary small', 'submit', false );
                            ?>
                        </form>
                        
                        <!--delete custom post type from array of cpts -->

                        <form method="post" action="options.php" class="inline-block">
                            <?php
                                settings_fields( 'yvic_plugin_tax_settings' );
                            ?>
                            <input type="hidden" name="remove" value="<?=$option['taxonomy']?>" />
                            <?php
                                submit_button( 'Delete', 'delete small', 'submit', false, 
                                    array(
                                        'onclick' => "return confirm('Are you sure you want delete this taxonomy? The data associated with it will not be deleted');"
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
        <div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_taxonomy']) || isset($_POST['add_taxonomy']) ? 'active' : '' ?> ">
            <form method="post" action="options.php">
                <?php 
                    settings_fields( 'yvic_plugin_tax_settings' );
                    do_settings_sections( 'yvic_plugin_tax' );
                    submit_button();
                ?>
            </form>
        </div>
        <div id="tab-3" class="tab-pane">
            <h3>Export your Taxonomies</h3>

        </div>
    </div>
</div>