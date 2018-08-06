<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h2 class="page-header">Jobs <a href="/index.php?r=job/create" class="btn btn-primary pull-right">Create</a></h2>
<?php if(null !== Yii::$app->session->getFlash('success')):?>
    <div class="alert alert-success"><?php Yii::$app->session->getFlash('success'); ?></div>
<?php endif;?>
<?php if(!empty($jobs)):?>
    <ul class="list-group">
        <?php foreach($jobs as $job):?>
        <?php $phpdate = strtotime($job->create_date); ?>
        <?php $formatted_date = date("F j, Y, g:i a",$phpdate);?>
            <li class="list-group-item"><a href="/index.php?r=job/details&id=<?=$job->id;?>"><?php echo $job->title;?></a> - <strong><?= $job->city;?> <?= $job->state;?></strong> - Listed on <?= $formatted_date;?></li>
    <?php endforeach;?>
    </ul>
<?php else:?>
<p>No jobs to list</p>
<?php endif;?>


<?= LinkPager::widget(['pagination' => $pagination]);?>