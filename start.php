<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yerrr</title>
    <script src = "https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body oncontextmenu="return false;">

    <h1 id = "title">Work:</h1>

    <div id = "container">

        <div id = "grid"></div>
        <div id = "buttons"></div>
    </div>

    <script type="text/javascript">
$(document).ready(function () {

    let rowNum = <?php echo $_POST["row_amount"]; ?> ;
    let colNum = <?php echo $_POST["col_amount"]; ?> ;

    let bombCount = 0;  //amount of bombs
    let noneCount = 0;  //amount of empties (the number we are trying to reach)
    let totalCount = 0;  //the total amount of blocks
    let currentCount = 0; //the current amount of blocks we clicked on

    multiplier = 0.08 // number has to be 0 to 1, preferably between 0.00 and 0.10

    // TODO: Create a simple, nice looking home page with bootstrap
    // TODO: Make "back" button connect to home page
    // TODO: Reposition grid, reset and back button so they don't collide (use bootstrap idiot) 
    
// function clearBoard(){
//     createBoard(rowNum + 1, colNum + 1);    // starts the game
//     // showBoard();
// }

$('#reset').on('click',function(){
    clearBoard();
});

$('#back').on('click',function(){
    // go back to main page
});

function showBoard(){

    $('.empty').css("background-color", "#F39237");

    $('.bomb').css({"background-color": "#1C77C3",
        "background": "url(\"bomb.png\")"
    });

    $('.adj').css("background-color", "#40BCD8");

}


function getRandInt(start, end){
    return (Math.floor(Math.random() * end) + start);
}

/**
 *
 * @param arr - the board
 * @param i - i coord
 * @param j - j coord
 * @returns {number} - the number of adjacent bombs
 */

function checkAround(arr, i, j){
    let count = 0;
    try{

        // top row
        if(arr[i - 1][j-1] === "X"){ count += 1; }
        if(arr[i - 1][j] === "X"){ count += 1; }
        if(arr[i - 1][j + 1] === "X"){ count += 1; }

        // middle row
        if(arr[i][j-1] === "X"){ count += 1; }
        if(arr[i][j + 1] === "X"){ count += 1; }

        // bottom row
        if(arr[i + 1][j-1] === "X"){ count += 1; }
        if(arr[i + 1][j] === "X"){ count += 1; }
        if(arr[i + 1][j + 1] === "X"){ count += 1; }

    }catch(err){
        console.log("Error: " + err)
    }
    return count;
}

//Creates the grid in html
function getGrid(arr, row, col){

    let str = "";
    let type = "";
    let id = "";

    for (let i = 1; i<= row - 1; i++){

        for (let j = 1; j <= col - 1; j++){

            if (arr[i][j] === "X"){  //bomb
                type = "bomb";
                bombCount += 1;
            }else if (arr[i][j] === "0") {  //empty
                type = "empty";
                noneCount += 1;
            }else{  //adjacent
                type = "adj";
                noneCount += 1;
            }

            totalCount += 1;

            id = i.toString() + "-" + j.toString();
            str += "<button id= \"" + id + '\"  class = \"' + type + '\"><span> ' +
                 + arr[i][j].toString() + "</span></button>";

        }

    }

    $('#grid').html(str);
    createCSS(row, col, arr);

}

function createCSS(row, col, arr){
    let startX = 100;
    let startY = 100;
    let id = "";

    for (let i = 1; i<= row - 1; i++) {

        startX = 100;

        for (let j = 1; j <= col - 1; j++) {

            id = i.toString() + "-" + j.toString();

            $("#" + id).css({
                position: "absolute",
                width: "50px",
                height: "50px",
                top: startY.toString() + "px",
                left: startX.toString() + "px",
                "background-color" : "#F39237"
            });

            $("#" + id + " span").hide();

            startX = startX + 50;
        }

        startY = startY + 50;
    }

    // when left click
    $('button').mousedown(function(e){

        let s = "#" + e.currentTarget.id.toString();
        let current_i = Number(s.substring(1, s.indexOf("-")));
        let current_j = Number(s.substring(s.indexOf("-") + 1, s.length));

        if ( $(s).hasClass("isShown")){
        }else{
            switch (e.currentTarget.className.toString()){
                case ("empty"):
                    checkEmpty(arr, current_i, current_j);
                    // console.log("No. trying to reach: " + noneCount);
                    // console.log("No. of Bombs: " + bombCount);
                    // console.log("No. of currently clicked blocks: " + currentCount);
                    break;
                case("adj"):
                    $(s + " span").show();
                    $(s).css("background-color", "#40BCD8");
                    $(s).addClass("isShown");
                    currentCount += 1;
                    // console.log("No. trying to reach: " + noneCount);
                    // console.log("No. of Bombs: " + bombCount);
                    // console.log("No. of currently clicked blocks: " + currentCount);

                    break;
                case("bomb"):
                    $('.bomb').css({"background-color": "#1C77C3",
                        "background": "url(\"bomb.png\")"
                    });
                    alert("game over");
                }
                if (noneCount === currentCount){
                    alert("you win!");
                }
            }


    });

}

function checkEmpty(arr, i, j){

    let s = "#" + i.toString() + "-" + j.toString();
    let id = $(s);
    let _id = $(s + " span");

    if (i < 1 || i > arr.length || j > arr.length || j < 1 || id.hasClass("isShown")){ return; }
    else if(id.hasClass("adj")){

        _id.show();
        id.addClass("isShown");
        currentCount += 1;
        id.css("background-color", "#40BCD8");

        return;

    }else if(id.hasClass("empty") === false){

        return;

    }

    else{

        currentCount += 1;

    }

    _id.show();

    id.addClass("isShown");

    //bottom
    checkEmpty(arr, i + 1, j - 1); // bottom-left
    checkEmpty(arr, i + 1, j); // bottom-middle
    checkEmpty(arr, i + 1, j + 1); // bottom-right

    // top
    checkEmpty(arr, i - 1, j - 1); // top-left
    checkEmpty(arr, i - 1, j); // top-middle
    checkEmpty(arr, i - 1, j + 1); // top-right

    // left
    checkEmpty(arr, i + 1, j - 1); // left-down
    checkEmpty(arr, i, j - 1); // left-middle
    checkEmpty(arr, i - 1, j - 1); // left-top

    // right
    checkEmpty(arr, i + 1, j + 1); // right-down
    checkEmpty(arr, i, j + 1); // right-middle
    checkEmpty(arr, i - 1, j + 1); // right-top

}

function createBoard(row, col){

    let arr = [];
    let arrNum = [];
    let arr1 = [];

    // creates initial board
    for (i = 0; i<= row; i++){
        arr = [];
        count = 0;
        for (j = 0; j <= col; j++){
            arr.push("0");
            arrNum.push(getRandInt(0, row));
        }
        for (let k = 0; k <= Math.floor(arrNum.length * multiplier); k++){
            arr[arrNum[k]] = "X";
        }
        arr1.push(arr);
        arrNum = [];
    }

    // adds edges for the space
    for (i = 0; i<= row; i++){
        for (j = 0; j <= col; j++){
            if (i === 0 || i === row || j === 0 || j === col){
                arr1[i][j] = "0";
            }
        }
    }

    // creates the numbers for the adjacent bomb spaces
    for(i = 1; i < row; i ++){
        for (j = 1; j < col; j ++){
            if (arr1[i][j] === "X"){
                //do nothing
            }else if (arr1[i][j] === "0"){
                if (checkAround(arr1, i, j) !== 0){
                    arr1[i][j] = checkAround(arr1, i , j).toString();
                }
            }
        }
    }

    getGrid(arr1, row, col);
    return arr1;
}

createBoard(rowNum + 1, colNum + 1);    // starts the game
// showBoard();

});







</script>


</body>

</html>