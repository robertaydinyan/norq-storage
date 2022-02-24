function addPopup(id){
     $('#addGroup').modal('show'); 
     $('#group_id').val(id);
}
function editePopup(id, el_){
    $('#editeGroup').modal('show');
    var name = el_.closest('.parent-block').attr('data-name');
    $('#fname__').val(name);
    $('#id').val(id);
}
function deletePopup(id, el_){
    var res = confirm('Ջնջել ՞');
    if(res){
        $.ajax({
            url: '/group-product/delete-group',
            method: 'get',
            dataType: 'html',
            data: { id: id},
            success: function (data) {
               window.location.reload();
            }
        });
    } else {
        return false;
    }
}
function getProducts(id){
    $('#nomiclature_id').val(id);
    $.ajax({
        url: '/product/get-popup-products-by-id',
        method: 'get',
        dataType: 'html',
        data: { id: id},
        success: function (data) {
            $('#products').html(data);
        }
    });
}
function setGroup(id){
    $('#group').val(id);
}

function deleteSup(id, el_){
    var res = confirm('Ջնջել ՞');
    if(res){
        $.ajax({
            url: '/suppliers-list/delete-sup',
            method: 'get',
            dataType: 'html',
            data: { id: id},
            success: function (data) {
                window.location.reload();
            }
        });
    } else {
        return false;
    }
}
function deleteProduct(id){
    var res = confirm('Ջնջել ՞');
    if(res){
        $.ajax({
            url: '/product/delete-product',
            method: 'get',
            dataType: 'html',
            data: { id: id},
            success: function (data) {
                window.location.reload();
            }
        });
    } else {
        return false;
    }
}

var folder = $('.file-tree li.file-tree-folder'),
    treeBtn = $('.file-tree li.file-tree-folder span').not('.fa-plus'),
    file = $('.file-tree li');

treeBtn.on("click", function(a) {
    $(this).parent("li").children('ul').slideToggle(100, function() {
        $(this).parent("li").toggleClass("open");
        localStorage.clear();
        $('.file-tree-folder').not('.open').each(function(){
            var key_ = $(this).find('span').first().attr('data-name');
            localStorage.setItem(key_, true);
        });
    }), a.stopPropagation()
})
//
// file.on('click', function(b){
//     console.log($(this))
//     b.stopPropagation();
// })

setTimeout(function(){
     for (var key in localStorage){
        console.log('span[data-name="'+key+'"]');
       $('span[data-name="'+key+'"]').click();
    }
},200);
$(document).ready ( function(){
    treeBtn.parent("li").children('ul').slideToggle(100, function() {
        $(this).parent("li").toggleClass("open")
    });
   
});