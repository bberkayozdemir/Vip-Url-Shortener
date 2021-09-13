<div class="row">
    <div class="col-md-12">
        <div class="urltable-head">

            <div class="urltable-th ut-summary">
                Name
            </div>
            <div class="urltable-th ut-clicks">
                Clicks
            </div>
            <div class="urltable-th ut-password">
                Total URLs
            </div>
            <div class="urltable-th ut-expires-at">
                Register Date
            </div>
            <div class="urltable-th ut-status">
                Status
            </div>
            <div class="urltable-th ut-actions">
                
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="url-table">

        <?php

        if (!empty($user_list))
        {
            foreach ($user_list as $row)
            {
               ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="urlbox-row">
                            <div class="urlbox-td urlbox-head">
                                <div class="urlbox-url">
                                <?php 
                                if (strlen($row["name"]) > 40)
                                    echo substr($row["name"],0,40)."...";
                                else
                                    echo $row["name"];
                                ?>
                                </div>

                            </div>
                            <div class="urlbox-td urlbox-clicks">
                                <span class="hidden-text">Clicks: </span><?=$row["views"]?>
                            </div>
                            <div class="urlbox-td urlbox-password">
                                <?=$row["total_urls"]?>
                            </div>
                            <div class="urlbox-td urlbox-expires-at">

                                <?php
                                    if (!empty($row["register_date"]))
                                        echo date("m/d/Y", strtotime($row["register_date"]));
                                    else
                                        echo "-";

                                ?>
                            </div>
                            <div class="urlbox-td urlbox-status">
                                <span class="hidden-text">Status: </span>
                                <div>
                                <?php 
                                    if ($row["status"] == 1)
                                        echo "Enabled";
                                    else
                                        echo "Disabled";
                                    ?>
                                </div>
                            </div>

                            <div class="urlbox-td urlbox-actions" data-id="<?=$row["id"]?>">

                                <a data-toggle="tooltip" data-placement="bottom" data-action="view" title="Urls statistics" href="<?=base_url()?>admin/users/<?=$row["id"]?>"><i class="fas fa-link"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-action="view_urls" title="Show All Urls Of User" href="<?=base_url()?>admin/urls/user/<?=$row["id"]?>"><i class="fas fa-external-link-alt"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-action="view_user" title="View User" href="#"><i class="fas fa-eye"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-action="edit" title="Edit User" href="#"><i class="fas fa-edit"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-status="<?=$row["status"]?>" data-action="status" title="
                                <?php 
                                    if ($row["status"] == 1)
                                        echo "Disable";
                                    else
                                        echo "Enable";
                                ?> User" href="#"><i class="fas fa-power-off"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-action="delete" title="Delete User And Users All URLS" href="#"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

        <?php 

            }

            ?>

            

            <?php
        }else{
            echo '<center style="margin-top:20px">Nothing to show...</center>';
        }

        ?>

    </div>

    

</div>

<?php

    if (!empty($user_list))
    {
        ?>
    <div class="urltable-pagination">
        <nav>
            <ul class="pagination">

                <?php 
                if (isset($pagination)) 
                    echo $pagination;
                ?>
            </ul>
        </nav>
        
    </div>

<?php } ?>

<script>
    $('.urltable-content [data-toggle="tooltip"]').tooltip();
</script>