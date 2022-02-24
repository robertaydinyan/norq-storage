<?php
use yii\helpers\Url;
?>
<div id="sidenav" class="sidenav">
    <a href="/">
        <img src="/images/logo.svg" class="navbar-logo" alt="logo" width="32">
        <span style="font-size: 12px"> NORQ </span>
    </a>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="<?php echo Url::to(['/complectation']); ?>">Կոմպլեկտացիա</a>
    <!-- <a href="<?php echo Url::to(['/complectation-products']); ?>">Կոմպլեկտավորման արտադրանք</a> -->
    <!-- <a href="<?php echo Url::to(['/partners-list']); ?>">Գործընկերներ</a> -->
    <!-- <a href="<?php echo Url::to(['/payments']); ?>">վճարումներ</a> -->
    <a href="<?php echo Url::to(['/payments-log']); ?>">Վճարումների ցուցակ</a>
    <a href="<?php echo Url::to(['/product']); ?>">Ապրանքներ</a>
    <!-- <a href="<?php echo Url::to(['/nomenclature-product']); ?>">Ապրանքի Նոմենկլատուրա</a> -->
    <!-- <a href="<?php echo Url::to(['/qty-type']); ?>">Չափման միավոր</a> -->
    <!-- <a href="<?php echo Url::to(['/shipping-type']); ?>">Տեղափոխության տեսակներ</a> -->
    <!-- <a href="<?php echo Url::to(['/status-list']); ?>">Ստատուսներ</a> -->
    <!-- <a href="<?php echo Url::to(['/warehouse-types']); ?>">Պահեստի տեսակներ</a> -->
    <!-- <a href="<?php echo Url::to(['/warehouse-groups']); ?>">Պահեստ</a> -->
    <!-- <a href="<?php echo Url::to(['/suppliers-list']); ?>">Գործընկերներ</a> -->
    <!-- <a href="<?php echo Url::to(['/group-product']); ?>">Ապրանքի խումբ</a> -->
    <!-- <a href="<?php echo Url::to(['/complectation-shipping']); ?>">Կոմպլեկտացիաի տեղափոխություն</a> -->
    <a href="<?php echo Url::to(['/reports']); ?>">զեկույցներ</a>
    <a href="<?php echo Url::to(['/shipping']); ?>">Տեղափոխություն</a>
    <!-- <a href="<?php echo Url::to(['/shipping-product']); ?>">Ապրանքի տեղափոխություն</a> -->
    <a href="<?php echo Url::to(['/shipping-request']); ?>">Հարցումներ</a>
    <!-- <a href="<?php echo Url::to(['/warehouse']); ?>">Հիմնական պահեստ</a> -->
</div>

<!-- Use any element to open the sidenav -->
<span onclick="openNav()">open</span>

<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
