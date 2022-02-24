<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Drag and drop</h1>
        <div id="sortable">
            <div class="ui-state-default">Item 1</div>
            <div class="ui-state-default">Item 2</div>
            <div class="ui-state-default">Item 3</div>
            <div class="ui-state-default">Item 4</div>
            <div class="ui-state-default">Item 5</div>
        </div>
            
    </div>

</div>

<style>
    .ui-state-default {
        font-size: 20px;
        padding: 12px;
    }
    #sortable {
        user-select: none; 
    }
</style>