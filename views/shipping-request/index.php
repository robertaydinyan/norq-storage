<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShippingRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Հարցումներ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/contact.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<div class="shipping-request-index group-product-index">
    <nav id="w5" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w5-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <?php $uri = explode('?',$_SERVER['REQUEST_URI']); ?>
                 <li class="nav-item "><a class="nav-link <?php if(!isset($_GET['type'])){ echo 'active';} ?>" href="<?php echo $uri[0];?>">Բոլորը</a></li>
                 <?php foreach ($shipping_types as $shp_type => $shp_type_val){ ?>
                   <li class="nav-item "><a class="nav-link <?php if(isset($_GET['type']) && ($_GET['type']==$shp_type_val->id)){ echo 'active';} ?>" href="?type=<?php echo $shp_type_val->id;?>"><?php echo $shp_type_val->name;?></a></li>
                 <?php } ?>
            </ul>
        </div>
    </nav>

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?>
        <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success" >Ստեղծել հարցում</a>
    </h4>


    <div style="padding:20px;">
        <form class="row" action="" method="get">
<<<<<<< HEAD
            
            <div class="col-sm-auto shipping-request-filter">
                <button type="button" class="btn btn-primary form-control">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
            <div class="col-sm-12" style="margin-bottom: 10px; display: none">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="">ընդունող պահեստ</label>
                        <select name="provider_warehouse_id" class="form-control">
                            <option value=""></option>
=======
            <div class="col-sm-4" style="margin-bottom: 10px;">
                <div class="row">
                    <div class="col-sm-4">
                        <select name="provider_warehouse_id" class="form-control">
                            <option value="">ընդունող պահեստ</option>
>>>>>>> 3838effda7d0739e89e30adcf97e1b0164696881
                            <?php if(!empty($warehouses)){
                                foreach ($warehouses as $warehouse =>$wh){
                                    if(@$_GET['provider_warehouse_id'] == $warehouse){
                                        $act = 'selected';
                                    } else {
                                        $act = '';
                                    }
                                    echo '<option value="'.$warehouse.'" '.$act.'>'.$wh.'</option>';
                                }
                            } ?>
                        </select>
                    </div>
<<<<<<< HEAD
                    <div class="col-sm-2">
                        <label for="">ստացող պահեստ</label>
                        <select name="supplier_warehouse_id" class="form-control">
                            <option value=""></option>
=======
                    <div class="col-sm-4">
                        <select name="supplier_warehouse_id" class="form-control">
                            <option value="">ստացող պահեստ</option>
>>>>>>> 3838effda7d0739e89e30adcf97e1b0164696881
                            <?php if(!empty($warehouses)){
                                foreach ($warehouses as $warehouse =>$wh){
                                    if(@$_GET['supplier_warehouse_id'] == $warehouse){
                                        $act = 'selected';
                                    } else {
                                        $act = '';
                                    }
                                    echo '<option value="'.$warehouse.'" '.$act.'>'.$wh.'</option>';
                                }
                            } ?>
                        </select>
                    </div>
<<<<<<< HEAD
                    <div class="col-sm-2">
                        <label for="">Պատասխանատու</label>
                        <select name="user_id" class="form-control">
                            <option value=""></option>
=======
                    <div class="col-sm-4">
                        <select name="user_id" class="form-control">
                            <option value="">Պատասխանատու</option>
>>>>>>> 3838effda7d0739e89e30adcf97e1b0164696881
                            <?php if(!empty($users)){
                                foreach ($users as $user =>$usval){
                                    if(@$_GET['user_id'] == $user){
                                        $act = 'selected';
                                    } else {
                                        $act = '';
                                    }
                                    echo '<option value="'.$user.'" '.$act.'>'.$usval.'</option>';
                                }
                            } ?>
                        </select>
                    </div>
<<<<<<< HEAD

                    <div class="col-sm-2">
                        <label for="">սկիզբ</label>
                        <input type="text"   value="<?php echo @$_GET['from_created_at'];?>" name="from_created_at" class="form-control datepicker" />
                    </div>
                    <div class="col-sm-2">
                        <label for="">ավարտ</label>
                        <input type="text" value="<?php echo @$_GET['to_created_at'];?>" placeholder="" name="to_created_at" class="form-control datepicker" />
                    </div>
                    <div class="col-sm-1" style="margin-top: 29px;">
                        <button type="button" class="btn btn-default" style="color:black;" data-toggle="modal" data-target="#suppliersModal">Մատակարարներ</button>
                        <div class="modal fade" id="suppliersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php $id = @intval($_GET['ShippingRequest']['supplier_id']); ?>
                                        <ul class="file-tree" style="border:1px solid #dee2e6;padding-left: 35px;padding-top: 5px;margin-top:0px;">
                                            <?php foreach ($suppliers as $tableTreePartner) : ?>
                                                <li class="file-tree-folder">
                                <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
                                </span>
                                                    <ul style="display: block;">
                                                        <?= \Yii::$app->view->renderFile('@app/views/suppliers-list/tree_form_sup_table.php', [
                                                            'tableTreePartner' => $tableTreePartner,
                                                            'checked' => $id,
                                                        ]); ?>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 29px; margin-left: 12px;">
=======
                </div>

            </div>
            <div class="col-sm-2">
                <input type="text"   value="<?php echo @$_GET['from_created_at'];?>" placeholder="սկիզբ" name="from_created_at" class="form-control datepicker" />
            </div>
            <div class="col-sm-2">
                <input type="text" value="<?php echo @$_GET['to_created_at'];?>" placeholder="ավարտ" name="to_created_at" class="form-control datepicker" />
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" style="color:black;" data-toggle="modal" data-target="#suppliersModal">Մատակարարներ</button>
                <div class="modal fade" id="suppliersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php $id = @intval($_GET['ShippingRequest']['supplier_id']); ?>
                                <ul class="file-tree" style="border:1px solid #dee2e6;padding-left: 35px;padding-top: 5px;margin-top:0px;">
                                    <?php foreach ($suppliers as $tableTreePartner) : ?>
                                        <li class="file-tree-folder">
                         <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
                        </span>
                                            <ul style="display: block;">
                                                <?= \Yii::$app->view->renderFile('@app/views/suppliers-list/tree_form_sup_table.php', [
                                                    'tableTreePartner' => $tableTreePartner,
                                                    'checked' => $id,
                                                ]); ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="col-sm-2">
                <div class="row">
                    <div class="col-sm-6">
>>>>>>> 3838effda7d0739e89e30adcf97e1b0164696881
                        <button type="submit" class="btn btn-primary form-control">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <br>
    <?php if(!isset($_GET['type']) || $_GET['type']==7){
        $columns = [
        'id',
        [
            'attribute' => 'shippingType',
            'label' => 'Տեղափոխման տեսակ',
            'value' => function ($model) {
                return $model->shippingtype->name;
            }
        ],
        [
            'attribute' => 'providerWarehouse',
            'label' => 'Առաքող պահեստ',
            'value' => function ($model) {
                return $model->provider->name;
            }
        ],
        [
            'attribute' => 'supplierWarehouse',
            'label' => 'Ստացող պահեստ',
            'value' => function ($model) {
                return $model->supplier->name;
            }
        ],
        [
            'attribute' => 'supplier',
            'label' => 'Պատասխանատու',
            'value' => function ($model) {
                return $model->user->name.' '.$model->user->last_name;
            }
        ],
            [
                'label' => 'Ընդ ․գումար',
                'value' => function ($model) {
                    return number_format($model->totalsum,'0','.',',').' դր․';
                }
         ],
        [
            'label' => 'Ստեղծվել է',
            'value' => function ($model) {
                return date('d.m.Y',strtotime($model->created_at));
            }
        ],
        [
            'label' => 'Կարգավիճակ',
            'value' => function ($model) {
                return $model->status_->name;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Հղում'),
            'template' => '{view}{update}{accept}{decline}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<i class="far fa-eye"></i>', $url, [
                        'title' => Yii::t('app', 'Դիտել'),
                        'class' => 'btn btn-secondary  btn-sm mr-2'
                    ]);
                },
                'update' => function ($url, $model) {
                    if($model->status != 3) {
                        return Html::a('<i class="far fa-pencil"></i>', $url, [
                            'title' => Yii::t('app', 'Փոփոխել'),
                            'class' => 'btn btn-secondary  btn-sm mr-2'
                        ]);
                    } else {
                        return '';
                    }
                },
                  'accept' => function ($url, $model) {
                           if($model->status == 2) {
                               return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url, [
                                   'title' => Yii::t('app', 'Հաստատել'),
                                   'class' => 'btn btn-primary  btn-sm mr-2'
                               ]);
                           } else if($model->status == 5 && \Yii::$app->user->can('admin')){
                              return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', '/shipping-request/accept-admin?id='.$model->id, [
                                   'title' => Yii::t('app', 'Հաստատել'),
                                   'class' => 'btn btn-primary  btn-sm mr-2'
                               ]);
                           }
                       },
                       'decline' => function ($url, $model) {
                           if($model->status == 2) {
                               return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url, [
                                   'title' => Yii::t('app', 'Մերժել'),
                                   'class' => 'btn btn-danger  btn-sm mr-2'
                               ]);
                           } else if($model->status == 5 && \Yii::$app->user->can('admin')){
                              return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', '/shipping-request/decline-admin?id='.$model->id, [
                                   'title' => Yii::t('app', 'Մերժել'),
                                   'class' => 'btn btn-danger  btn-sm mr-2'
                               ]);
                           }
                       },
            ]
        ],
    ];
    }
       else if($_GET['type']==6 || $_GET['type']== 2 || $_GET['type']== 5){
        $columns = [
            'id',
            [
                'attribute' => 'shippingType',
                'label' => 'Տեսակը',
                'value' => function ($model) {
                    return $model->shippingtype->name;
                }
            ],
            [
                'attribute' => 'supplierWarehouse',
                'label' => 'Ստացող պահեստ',
                'value' => function ($model) {
                    return $model->supplier->name;
                }
            ],
            [
                'attribute' => 'supplier',
                'label' => 'Պատասխանատու',
                'value' => function ($model) {
                    return $model->user->name.' '.$model->user->last_name;
                }
            ],
            [
                'attribute' => 'supplier',
                'label' => 'Մատակարար',
                'value' => function ($model) {
                    return $model->supplierp->name;
                }
            ],
            [
                'label' => 'Ընդ ․գումար',
                'value' => function ($model) {
                    return number_format($model->totalsum,'0','.',',').' դր․';
                }
            ],
            [
                'attribute' => 'invoice',
                'label' => 'Invoice',
                'value' => function ($model) {
                    return $model->invoice;
                }
            ],
            [
                'label' => 'Կարգավիճակ',
                'value' => function ($model) {
                    return $model->status_->name;
                }
            ],
            [
                'label' => 'Ստեղծվել է',
                'value' => function ($model) {
                    return date('d.m.Y',strtotime($model->created_at));
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Հղում'),
                'template' => '{view}{update}{accept}{decline}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="far fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn btn-secondary  btn-sm mr-2'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        if($model->status != 3) {
                            return Html::a('<i class="far fa-pencil"></i>', $url, [
                                'title' => Yii::t('app', 'Փոփոխել'),
                                'class' => 'btn btn-secondary  btn-sm mr-2'
                            ]);
                        } else {
                            return '';
                        }
                    },
                    'accept' => function ($url, $model) {
                        if($model->status == 2) {
                            return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url, [
                                'title' => Yii::t('app', 'Հաստատել'),
                                'class' => 'btn btn-primary  btn-sm mr-2'
                            ]);
                        }
                    },
                    'decline' => function ($url, $model) {
                        if($model->status == 2) {
                            return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url, [
                                'title' => Yii::t('app', 'Մերժել'),
                                'class' => 'btn btn-danger  btn-sm mr-2'
                            ]);
                        }
                    },
                ]
            ],
        ];
    }
       else if($_GET['type']==8 || $_GET['type']==10 ){
        $columns = [
            'id',
            [
                'attribute' => 'shippingType',
                'label' => 'Տեղափոխման տեսակ',
                'value' => function ($model) {
                    return $model->shippingtype->name;
                }
            ],
            [
                'attribute' => 'supplierWarehouse',
                'label' => 'Հանձնող պահեստ',
                'value' => function ($model) {
                    return $model->provider->name;
                }
            ],
            [
                'attribute' => 'supplier',
                'label' => 'Պատասխանատու',
                'value' => function ($model) {
                    return $model->user->name.' '.$model->user->last_name;
                }
            ],
            [
                'label' => 'Կարգավիճակ',
                'value' => function ($model) {
                    return $model->status_->name;
                }
            ],

            [
                'label' => 'Ընդ ․գումար',
                'value' => function ($model) {
                    return number_format($model->totalsum,'0','.',',').' դր․';
                }
            ],
            [
                'label' => 'Ստեղծվել է',
                'value' => function ($model) {
                    return date('d.m.Y',strtotime($model->created_at));
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Հղում'),
                'template' => '{view}{update}{accept}{decline}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="far fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn btn-secondary  btn-sm mr-2'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        if($model->status != 3) {
                            return Html::a('<i class="far fa-pencil"></i>', $url, [
                                'title' => Yii::t('app', 'Փոփոխել'),
                                'class' => 'btn btn-secondary  btn-sm mr-2'
                            ]);
                        } else {
                            return '';
                        }
                    },
                      'accept' => function ($url, $model) {
                           if($model->status == 2) {
                               return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url, [
                                   'title' => Yii::t('app', 'Հաստատել'),
                                   'class' => 'btn btn-primary  btn-sm mr-2'
                               ]);
                           } else if($model->status == 5 && \Yii::$app->user->can('admin')){
                              return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', '/shipping-request/accept-admin?id='.$model->id, [
                                   'title' => Yii::t('app', 'Հաստատել'),
                                   'class' => 'btn btn-primary  btn-sm mr-2'
                               ]);
                           }
                       },
                       'decline' => function ($url, $model) {
                           if($model->status == 2) {
                               return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url, [
                                   'title' => Yii::t('app', 'Մերժել'),
                                   'class' => 'btn btn-danger  btn-sm mr-2'
                               ]);
                           } else if($model->status == 5 && \Yii::$app->user->can('admin')){
                              return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', '/shipping-request/decline-admin?id='.$model->id, [
                                   'title' => Yii::t('app', 'Մերժել'),
                                   'class' => 'btn btn-danger  btn-sm mr-2'
                               ]);
                           }
                       },
                ]
            ],
        ];
    }
       else if($_GET['type']==9){
           $columns = [
               'id',
               [
                   'attribute' => 'shippingType',
                   'label' => 'Տեղափոխման տեսակ',
                   'value' => function ($model) {
                       return $model->shippingtype->name;
                   }
               ],
               [
                   'attribute' => 'supplierWarehouse',
                   'label' => 'Հանձնող պահեստ',
                   'value' => function ($model) {
                       return $model->provider->name;
                   }
               ],
               [
                   'attribute' => 'supplier',
                   'label' => 'Պատասխանատու',
                   'value' => function ($model) {
                       return $model->user->name.' '.$model->user->last_name;
                   }
               ],
               [
                   'attribute' => 'supplier',
                   'label' => 'Գործընկեր',
                   'value' => function ($model) {
                       if($model->is_phys == 0){
                         return $model->supplierp->name;
                      } else {
                         return $model->supplierp->name.' '.$model->supplierp->surname;
                      }
                   }
               ],
               [
                   'label' => 'Կարգավիճակ',
                   'value' => function ($model) {
                       return $model->status_->name;
                   }
               ],
               [
                   'label' => 'Ընդ ․գումար',
                   'value' => function ($model) {
                       return number_format($model->totalsumsale,'0','.',',').' դր․';
                   }
               ],
               [
                   'label' => 'Ստեղծվել է',
                   'value' => function ($model) {
                       return date('d.m.Y',strtotime($model->created_at));
                   }
               ],
               [
                   'class' => 'yii\grid\ActionColumn',
                   'header' => Yii::t('app', 'Հղում'),
                   'template' => '{view}{update}{accept}{decline}',
                   'buttons' => [
                       'view' => function ($url, $model) {
                           return Html::a('<i class="far fa-eye"></i>', $url, [
                               'title' => Yii::t('app', 'Դիտել'),
                               'class' => 'btn btn-secondary  btn-sm mr-2'
                           ]);
                       },
                       'update' => function ($url, $model) {
                           if($model->status != 3) {
                               return Html::a('<i class="far fa-pencil"></i>', $url, [
                                   'title' => Yii::t('app', 'Փոփոխել'),
                                   'class' => 'btn btn-secondary  btn-sm mr-2'
                               ]);
                           } else {
                               return '';
                           }
                       },
                       'accept' => function ($url, $model) {
                           if($model->status == 2) {
                               return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url, [
                                   'title' => Yii::t('app', 'Հաստատել'),
                                   'class' => 'btn btn-primary  btn-sm mr-2'
                               ]);
                           } else if($model->status == 5 && \Yii::$app->user->can('admin')){
                              return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', '/shipping-request/accept-admin?id='.$model->id, [
                                   'title' => Yii::t('app', 'Հաստատել'),
                                   'class' => 'btn btn-primary  btn-sm mr-2'
                               ]);
                           }
                       },
                       'decline' => function ($url, $model) {
                           if($model->status == 2) {
                               return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url, [
                                   'title' => Yii::t('app', 'Մերժել'),
                                   'class' => 'btn btn-danger  btn-sm mr-2'
                               ]);
                           } else if($model->status == 5 && \Yii::$app->user->can('admin')){
                              return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', '/shipping-request/decline-admin?id='.$model->id, [
                                   'title' => Yii::t('app', 'Մերժել'),
                                   'class' => 'btn btn-danger  btn-sm mr-2'
                               ]);
                           }
                       },
                   ]
               ],
           ];
       }
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'',
        'columns' => $columns,
    ]); ?>
    </div>
    <div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="mod-content"></div>
                </div>
            </div>

        </div>
    </div>

</div>