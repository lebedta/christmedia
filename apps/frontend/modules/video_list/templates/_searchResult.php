<?php //if($result->getStatus() == 'Finished'): ?>
<!--    <img src="/images/finished_project.png" alt="The project was finished"/>-->
<?php //elseif($result->getStatus() == 'Faild'): ?>
<!--    <img src="/images/icon_archived_project.png" alt="Active project"/>-->
<?php //else: ?>
<!--    <img src="/images/project_small_bg.png" alt="Active project"/>-->
<?php //endif; ?>
<!---->
<?php //echo link_to($result->getTitle(), "@project_view?domain_name=".$result->getCompanySubDomain()."&project_id=".$result->getId()); ?>
<!--created by --><?php //echo link_to($result->getCreatorName(), "@user_info?domain_name=".$result->getCompanySubDomain()."&id=".$result->getUserId()); ?>
<?php echo $result->getTitle(); ?>