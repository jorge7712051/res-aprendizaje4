function test(num){
    $.ajax({
        url: 'Controllers/LRController.php',
        type: 'GET',
        data: { num },
        success: function(response) {
            console.log(response);
        }
    })
    
}