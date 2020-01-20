$(document).ready(function () {

    let rowNum = 20;
    let colNum = 20;

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
        if(arr[i - 1][j-1] === "X"){
            count += 1;
        }

        if(arr[i - 1][j] === "X"){
            count += 1;
        }

        if(arr[i - 1][j + 1] === "X"){
            count += 1;
        }

        if(arr[i][j-1] === "X"){
            count += 1;
        }

        if(arr[i][j + 1] === "X"){
            count += 1;
        }

        if(arr[i + 1][j-1] === "X"){
            count += 1;
        }
        if(arr[i + 1][j] === "X"){
            count += 1;
        }
        if(arr[i + 1][j + 1] === "X"){
            count += 1;
        }

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
            }else if (arr[i][j] === "0") {  //empty
                type = "empty";
            }else{  //adjacent
                type = "adj";
            }

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

            //console.log("id: " + id + " startX: " + startX.toString() + " startY: " + startY.toString());

            startX = startX + 50;
        }

        startY = startY + 50;
    }

    $('button').click(function(e){
        let s = "#" + e.currentTarget.id.toString();
        let current_i = Number(s.substring(1, s.indexOf("-")));
        let current_j = Number(s.substring(s.indexOf("-") + 1, s.length));
        console.log("-----");
        if ( $(s).hasClass("isShown")){
            console.log("reached isShown ");
        }else{
            switch (e.currentTarget.className.toString()){
                case ("empty"):
                    checkEmpty(arr, current_i, current_j);
                    break;
                case("adj"):
                    $(s + " span").show();
                    $(s).css("background-color", "#40BCD8");

                    break;
                case("bomb"):
                    $('.bomb').css({"background-color": "#1C77C3",
                        "background": "url(\"bomb.png\")"
                    });
            }}



    });

    //Keep this code up while you implement algorithm to check adjacent. Afterwards, you can delete this
    $('.empty').css("background-color", "#F39237");

    $('.bomb').css({"background-color": "#1C77C3",
        "background": "url(\"bomb.png\")"
    });

    $('.adj').css("background-color", "#40BCD8");

}

function checkEmpty(arr, i, j){

    let s = "#" + i.toString() + "-" + j.toString();
    let id = $(s);
    let _id = $(s + " span");

    if (i < 1){
        return;
    }
    else if(id.hasClass("adj")){
        _id.show();
        id.css("background-color", "#40BCD8");
        return;
    }else if(id.hasClass("empty") === false){
        return;
    }
    else if(j > arr.length){
        return;
    }
    else if(j < 1){
        return;
    }
    else if(i > arr.length){
        return;
    }else if(id.hasClass("isShown")){
        return;
    }

    _id.show();

    id.addClass("isShown");

    checkEmpty(arr, i + 1, j);
    checkEmpty(arr, i + 1, j + 1);
    checkEmpty(arr, i + 1, j - 1);

    checkEmpty(arr, i - 1, j);
    checkEmpty(arr, i - 1, j + 1);
    checkEmpty(arr, i - 1, j - 1);

    checkEmpty(arr, i, j + 1);
    checkEmpty(arr, i - 1, j + 1);
    checkEmpty(arr, i + 1, j + 1);

    checkEmpty(arr, i, j - 1);
    checkEmpty(arr, i + 1, j - 1);
    checkEmpty(arr, i - 1, j - 1);

}
function createBoard(row, col){

    rowAmount = row;
    colAmount = col;

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
        for (let k = 0; k <= Math.floor(arrNum.length * 0.1); k++){
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
    console.log(arr1);
    getGrid(arr1, row, col);
    return arr1;
}

console.log(createBoard(rowNum + 1, colNum + 1));

});

