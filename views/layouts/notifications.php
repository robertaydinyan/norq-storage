<?php
use app\models\Notifications;
$menu = [];
$user_id = Yii::$app->user->identity->id;
$notifiactionObj = new Notifications();
$notification_count = $notifiactionObj->getUserUnreadNotificationsCount($user_id);
$notifications = $notifiactionObj->getUserUnreadNotifications($user_id);

$string = '';
for($i = 0 ; $i<count($notifications);$i++){
    $string .= '<div class="dropdown-notifications-item-content " >
                   <a style="white-space: revert !important;" href="'.$notifications[$i]['notification_link'].'" notificationid="'.$notifications[$i]['id'].'" class="dropdown-item dropdown-notifications-item">
                    <div class="dropdown-notifications-item-content-text text-left" >'.$notifications[$i]['notification'].'</div>
                    <small class="dropdown-notifications-item-content-details text-left d-block">
                     '.date('d.m.Y g:i a',strtotime($notifications[$i]['creation_date'])).'
                    </small>
                    </a>';
    if($notifications[$i]['accept_url'] || $notifications[$i]['decline_url']){
        $string .= '<div class="control-buttons" style="margin-bottom:10px;">';
           if($notifications[$i]['accept_url']){
               $string .= '<a class="btn btn-success btn-sm" href="'.$notifications[$i]['accept_url'].'">Ընդունել</a>';
           }
            if($notifications[$i]['decline_url']){
                $string .= '<a class="btn btn-danger btn-sm" style="margin-left:10px;" href="'.$notifications[$i]['decline_url'].'">Մերժել</a>';
            }
        $string .= '</div>';
    }
    $string .= '</div>';
    $string .= '<hr style="margin:2px;">';
}

$this->registerJs("$('.fa-bell').closest('.dropdown-toggle').append('<small class=\"badge notifications-count badge-success\" style=\"top:-10px;font-size:50%;\">".$notification_count."</small>');
            $('.dropdown-notifications').on('click', 
                    function() { 
                        $('.dropdown-menu-messages').html(`".$string."`);                      
                        $('.dropdown-notifications-item').on('click',
                                function() {
                                    var nid = parseInt(this.getAttribute('notificationid'));
                                    $.ajax({
                                        url: '/site/notifications',
                                        method:'POST',
                                        data:{'id':nid}
                                    });                            
                                }            
                        ); 
                    }
            );   
            setInterval(function() {
                $.ajax({
                    url: '/site/notifications-update',
                    method:'GET',
                    success:function(data){
                        $('.dropdown-menu-messages').html(data);
                    }
                });                            
            },25000);   
        ");
?>
<div class=<?= $options['class'] ?> >
    <?php
    for($i = 0 ; $i < count($menu); $i++){
        if($notification_count!=''){
            echo "<span id='show_notifiactions' class='notification_exist ".$options['class']."-button'>";
        }
        else{
            echo "<span class='".$options['class']."-button'>";
        }
        echo '<i class="fa fa-bell" aria-hidden="true"></i>';
        if($notification_count>0){
            echo "<span class='".$options['class']."-count'>";
            echo $notification_count;
            echo '</span>';
        }
        echo '</span>';
    }
    echo '<div id="notifiactions_content">';
    echo '</div>';
    ?>
</div>