var timerFunction;

var imagePuzzle = {

    startGame: function (images, gridSize) {
        this.setImage(images, gridSize);
        $('#playPanel').show();
        // $('#sortable').randomize();
        this.enableSwapping('#sortable li');
    }, 
    enableSwapping: function (elem) {
        $(elem).draggable({
            snap: '#droppable',
            snapMode: 'outer',
            revert: "invalid",
            helper: "clone"
        });
        
        $(elem).droppable({
            drop: function (event, ui) {
                var $dragElem = $(ui.draggable).clone().replaceAll(this);
                $(this).replaceAll(ui.draggable);

                let array = [];
                currentList = $('#sortable > li').map(function (i, el) { 

                array.push($(el).attr('data-value'));
                return $(el).attr('data-value');
                     });
                array.pop();
                
                document.getElementById("puzzle-index").value = array;

                imagePuzzle.enableSwapping(this);
                imagePuzzle.enableSwapping($dragElem);

                return array;
                

            }
        });
    },
    
    setImage: function (images, gridSize) {
       
        gridSize = gridSize || 4; // If gridSize is null or not passed, default it as 4.
        console.log(gridSize);
        var percentage = 100 / (gridSize - 1);
        var image = images[Math.floor(Math.random() * images.length)];
        $('#imgTitle').html(image.title);

        $('#actualImage').attr('src', image.src);
        $('#sortable').empty();
        for (var i = 0; i < gridSize * gridSize; i++) {
            var xpos = (percentage * (i % gridSize)) + '%';
            var ypos = (percentage * Math.floor(i / gridSize)) + '%';
            var li = $('<li class="item" data-value="' + (i) + '"></li>').css({
                'background-image': 'url(' + image.src + ')',
                'background-size': (gridSize * 100) + '%',
                'background-position': xpos + ' ' + ypos,
                'width': 350 / gridSize,
                'height': 350 / gridSize,
                'border': '1px solid white',
            });
            $('#sortable').append(li);
        }
        // $('#sortable').randomize();
    }
};

function isSorted(arr) {
    for(var i = 0; i < arr.length - 1; i++) {
        if(arr[i] != i) 
            return false;
    }
    return true;
}
