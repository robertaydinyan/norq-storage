<?php
/* @var $this \yii\web\View */

/* @var $content string */

// use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
// use app\models\Users;

// $id = Yii::$app->user->id;
// $user = Users::find()->where(['id' => $id])->one();
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title>norq <?php /*echo Html::encode($this->title)*/ ?></title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/images/logo.svg"/>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="container-fluid">
    <!--  BEGIN NAVBAR  -->

        <div class="spinner-container">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="header-container fixed-top">
            <header class="header navbar navbar-expand-sm">

                <ul class="navbar-item theme-brand flex-row  text-center">
                    <li class="nav-item theme-logo">
                        <a href="/">
                            <img src="/images/logo.svg" class="navbar-logo" alt="logo">
                        </a>
                    </li>
                    <li class="nav-item theme-text">
                        <a href="/" class="nav-link"> NORQ </a>
                    </li>
                   <!-- <li>
                        <a href="#" class="open-nav" onclick="openNav()">&#9776;</a>
                    </li>-->
                    <!-- <li class="nav-item theme-text">
                        <a href="" class="nav-link subnav"> Menu1</a>
                    </li> -->
                    
                    
                </ul>

                <ul class="navbar-item flex-row ml-md-auto">
                    <li class="nav-item dropdown user-profile-dropdown">
                        <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <img src="/images/profile-3.jpeg" alt="avatar">
                        </a>
                        <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                            <div class="">
                                <!-- <div class="dropdown-item">
                                    <a class="" href="/user/user-profile">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        Պրոֆիլ </a>
                                </div> -->
                                <div class="dropdown-item">
                                    <a class="" href="/site/logout">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24"
                                            fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-log-out">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        Դուրս գալ </a>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </header>
        </div>
        <!--  END NAVBAR  -->
        <?php echo $this->render('aside'); ?>
        <div id="content" class="main-content">
            <div class="layout-px-spacing layout-px-spacing-custom card p-3 mt-2 mb-2" style="overflow: auto;">
                <?=$content?>
            </div>
        </div>
        
    </div>
</div>

<?php echo $this->render('notifications'); ?>
<?php echo $this->render('footer'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
