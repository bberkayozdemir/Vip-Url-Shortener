<div class="row">
    <div class="col-md-12">
        <div class="urltable-head">

            <div class="urltable-th ut-summary">
                Summary
            </div>
            <div class="urltable-th ut-clicks">
                Clicks
            </div>
            <div class="urltable-th ut-password">
                Password
            </div>
            <div class="urltable-th ut-expires-at">
                Expires At
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

        if (!empty($url_list))
        {
            foreach ($url_list as $row)
            {
               ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="urlbox-row">
                            <div class="urlbox-td urlbox-head">
                                <a target="_blank" class="urlbox-url" href="<?=$row["url"]?>"><img src="https://www.google.com/s2/favicons?domain=<?=$row["url"]?>"/>
                                <?php 
                                if (strlen($row["url"]) > 40)
                                    echo substr($row["url"],0,40)."...";
                                else
                                    echo $row["url"];

                                if ($row["description"] !== null && $row["description"] !== "")
                                    echo ' - <span>'.$row["description"].'</span>';
                                 else
                                    echo '<span></span>';
                                ?>
                                </a>

                                <a target="_blank" class="urlbox-surl" href="<?=base_url().$row["name"]?>">
                                <?php
                                    if (strlen(base_url().$row["name"]) > 40)
                                        echo substr(base_url().$row["name"],0,40)."...";
                                    else
                                        echo base_url().$row["name"];
                                ?>
                                </a>

                            </div>
                            <div class="urlbox-td urlbox-clicks">
                                <span class="hidden-text">Clicks: </span><?=$row["views"]?>
                            </div>
                            <div class="urlbox-td urlbox-password">
                                <?php

                                if ($row["password"] == null || $row["password"] == "")
                                    echo "No";
                                else
                                    echo "Yes";

                                ?>
                            </div>
                            <div class="urlbox-td urlbox-expires-at">

                                <?php
                                    if (!empty($row["expire_date"]))
                                        echo date("m/d/Y", strtotime($row["expire_date"]));
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

                            <div class="urlbox-td urlbox-actions" data-id="<?=$row["id"]?>" data-url="<?=base_url().$row["name"]?>">

                                <a data-toggle="tooltip" data-placement="bottom" data-action="view" title="Url statistics" href="<?=base_url()?>user/urls/<?=$row["id"]?>"><i class="fas fa-eye"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-action="copy" title="Copy Shorten Url" href="#"><i class="fas fa-copy"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-action="edit" title="Edit Url" href="#"><i class="fas fa-edit"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-status="<?=$row["status"]?>" data-action="status" title="
                                <?php 
                                    if ($row["status"] == 1)
                                        echo "Disable";
                                    else
                                        echo "Enable";
                                ?> Url" href="#"><i class="fas fa-power-off"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-action="delete" title="Delete Url" href="#"><i class="fas fa-trash"></i></a>
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

    if (!empty($url_list))
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