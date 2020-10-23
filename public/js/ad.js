$("#add-image").click(function() {
    const index = +$('#widgets-counter').val();
    console.log(index);
    const template = $('#ad_images').data('prototype').replace(/__name__/g,index);
    $('#ad_images').append(template);
    $('#widgets-counter').val(index+1);
    handleDelete();
});


function handleDelete () {
    $('button[data-action="delete"]').click( function() {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateIndex() {

    const count = $('#ad_images div.form-group').length;
    $('#widgets-counter').val(count);
}

updateIndex();
handleDelete();




