window.onload = game;

///////////////////////////////////////////////////////
///////////////////    VARIABLES     //////////////////
///////////////////////////////////////////////////////

//timer variables
var timer, time;

//keep track if the game is over
var gameOver = false;       //never changed? --alec

//start & end buttons
var startButton = document.getElementById("startGameButton");
var endButton = document.getElementById("endGameButton");

//variable for each keyboard press
var letter; 

//variable for user word - concatenates only matching letters
var userWord = "";

//array of five words
var fiveWords = new Array(5);
//var fiveWords = ["HELLO", "FRIEND", "FRIED", "CAT", "SCIENCE"];

//temp value storing the current word from the fiveWords array
var value = "";

//flag to keep track if there is a match
var isMatch = [false, false, false, false, false];

var userScore = 0;  //might not need

var start = false;
    
//keep track of how many words dont match userWord
var count = 0;
var count2 = 4;

//variables to track length of highlight. I can't really think of much else to fix the problem if the words are similar -- alec
var len1 = 0;
var len2 = 0;
var len3 = 0;
var len4 = 0;
var len5 = 0;

var json_words;

//holds the url used to get the words
var requestURL = 'DictionaryWords.php';

var request = new XMLHttpRequest();
request.open('GET', requestURL);
request.responseType = 'json';
request.send();

//loads the json object
request.onload = function() {
    json_words = request.response;
    loadFirstWords();
}

///////////////////////////////////////////////////////
///////////////////    start game    //////////////////
///////////////////////////////////////////////////////
function game() {
    //hide words
    //$(".fiveWords").hide(); //removed because the letters need to show when new game starts
    
    //move words --alec
//    myMove("1");
//    myMove("2");
//    myMove("3");
//    myMove("4");
//    myMove("5");
    
}

///////////////////////////////////////////////////////
////////////////// start game button //////////////////
///////////////////////////////////////////////////////
function startGame() {
    start = true;
    //show the words
    $(".fiveWords").show();
    //make button opaque
    document.getElementById("startGameButton").style.opacity = .4;
    //disable start game
    startButton.disabled = true;
    //make button opaque
    document.getElementById("endGameButton").style.opacity = 1;
    //enable the end button
    endButton.disabled = false;
    
    matchCheck = false;

    //display the text
    //$(".fiveWords").html("text");
    insertWords();
    
    //change value of game over -- alec
    gameOver = false;
    
    //reset user word -- alec
    userWord = "";
    
    //game();
    
    //start the timer
    startTimer();
    
    myMove("1");
    myMove("2");
    myMove("3");
    myMove("4");
    myMove("5");
    
}

//Alex's load words
function loadFirstWords() {
   for (var j = 0; j < 5; j++)
   {
       fiveWords[j] = json_words[j].word;
   }
}


function updateWord(arrayNumber)
{	
   var arraycount = arrayNumber;
   var key = fiveWords[arraycount];
   json_words[key] = null;
   delete json_words[key];
   count2++;
   fiveWords[arraycount] = json_words[count2].word;
   console.log(fiveWords[arraycount]);
 
/* 
   switch (arraycountarraycount) {
       case 0:
           document.getElementById("myAnimation1").innerHTML = fiveWords[0];
           break;
       case 1:
           document.getElementById("myAnimation2").innerHTML = fiveWords[1];
           break;
       case 2:
           document.getElementById("myAnimation3").innerHTML = fiveWords[2];
           break;
       case 3:
           document.getElementById("myAnimation4").innerHTML = fiveWords[3];
           break;
       case 4:
           document.getElementById("myAnimation5").innerHTML = fiveWords[4];
           break;
       default:
           break;
   }
   */
}

///////////////////////////////////////////////////////
//////////////// insert 5 words w/tags  ///////////////
///////////////////////////////////////////////////////
function insertWords(){
    for(var i = 1; i <= fiveWords.length; i++){
        document.getElementById("myAnimation" + i).innerHTML = fiveWords[i - 1];
        //fiveWords[i-1] = fiveWords[i-1].toUpperCase();
    }
    
    
}

/*test function, essentially just insert words but needed to make a new one -- alec*/
///////////////////////////////////////////////////////
/////////// insert 5 words w/tags and condition ///////
///////////////////////////////////////////////////////
function dehighlight(){
    for(var i = 1; i <= fiveWords.length; i++){
        //just took this substring from compare function
        var stringValue = fiveWords[i-1].substring(0, userWord.length).toUpperCase();
        //it reinserts words that are not valid, and keeps the word that is good.
        if(userWord != stringValue){
        document.getElementById("myAnimation" + i).innerHTML = fiveWords[i - 1];
        }
    }
}

///////////////////////////////////////////////////////
/////////////////// end game button  //////////////////
///////////////////////////////////////////////////////
function endGame() {
    start = false;
    //hide words
    $(".fiveWords").hide();
    //rid of opacity for start game button
    document.getElementById("startGameButton").style.opacity = 1;
    //enable start button
    startButton.disabled = false;
    //make button opaque for end game
    document.getElementById("endGameButton").style.opacity = .4;
    //disable the end button
    endButton.disabled = true;
    //get time score
    userScore = time;
    
    //change value of game over -- alec
    gameOver = true;
    
    //document.getElementById("myAnimation1").innerHTML = userScore.toString();
    
    //stop the timer
    clearInterval(timer);
    
    window.location.replace('https://typegamertype.000webhostapp.com//highscore.php?score=' + userScore);
}

///////////////////////////////////////////////////////
///////////////////      TIMER       //////////////////
///////////////////////////////////////////////////////
function startTimer() {
    //Reset timer back to 60 seconds
    time = 0;

    //Every 100ms the timer gets updated
    timer = setInterval(function () {
    if (gameOver == true) {
        endGame();
    }
        time += 0.01;
    //time = time -+ 0.1;
    $("#timer").html("<strong>"+time.toFixed(2)+"</strong>")
  },10);

}

///////////////////////////////////////////////////////
////////////////////   move words   ///////////////////
///////////////////////////////////////////////////////
function myMove(wordNumber) {
    //added style to this -- alec
    var elem = document.getElementById('test'+wordNumber);
    
    /*can implement later if we want, it's for a faster paced game. It should work -- alec*/
    //var RATE_INTERVAL = 0.5;
    var rate = 30;  //current speed at which words drop -- alec
    //rate = rate + RATE_INTERVAL;
    
    var pos = 0 //starting position of words -- alec
    var h = window.innerHeight;     //dynamic window height, should adjust to YOUR screen --alec
    var id = setInterval(frame, rate);  //function not sure what it does --alec
    function frame() {
         if(pos >= h*.65){
             clearInterval(id);
             //call a endGame function -- alec
             endGame();
         }
        else if(gameOver != false){
                clearInterval(id);  //resets interval -- alec
                //endGame();
        }
         else if (start == true){
             pos+=.5;
             //value;
             if(fiveWords[wordNumber-1].toUpperCase().localeCompare(userWord) == 0){ //if user whole word matches a word
                 //var index1 = isMatch.findIndex(checkTrue);
                 //throws and infinite loop without value reset -- alec
                 //document.getElementById('myAnimation'+wordNumber).innerHTML = "";
                 //value = "";
                 pos = 0;
                 //fiveWords[wordNumber-1] = 
				 updateWord(wordNumber - 1);
				 console.log(fiveWords[wordNumber - 1]);
                 document.getElementById("myAnimation"+wordNumber).innerHTML = fiveWords[wordNumber-1]; //undoes highlight on correct word
                 
                 //reset value and userword fixes the first typing issue -- alec
                 value = "";
                 userWord = "";


                 //myMove(index + 1);
             }
             else{
                elem.style.transform = "translateY(" + pos + "px)"; //else move it down
             }
         }
     }
}


///////////////////////////////////////////////////////
///////////////////on keyboard press://////////////////
///////////////////////////////////////////////////////
document.addEventListener('keydown', function(event){
     if (event.keyCode >= 65 && event.keyCode <= 90 ){
         letter = String.fromCharCode(event.keyCode);
         
//         console.log(letter);
//         userWord += letter;
//         console.log(userWord);
         
         //if word doesn't match, start new word
//         if(compareUserWord() == false){
//             userWord = letter;
//             console.log(userWord);
//         }
         compareUserWord();

     }    
} );


///////////////////////////////////////////////////////
//////////////////// compare user word ////////////////
///////////////////////////////////////////////////////
function compareUserWord(){
    
    //used for error checking
    console.log(letter);
    userWord += letter;
    console.log(userWord);
    
    //reset count to 0
    count = 0;
    
    //return if there are no words
    for(var i = 0; i < fiveWords.length; i++){
        if(fiveWords[i] == ""){
            return;
        }
    }
    
    //reset all to false each time
    for(var i = 0; i < isMatch.length; i++){
        isMatch[i] = false;
    }
    
    for(var i = 1; i <= fiveWords.length; i++){
        
        //make uppercase & substr matching number of chars in user's word
        value = fiveWords[i-1].substring(0, userWord.length).toUpperCase();
        
        //if userword == actual word
        if(userWord.localeCompare(fiveWords[i-1].toUpperCase()) == 0){
            //fiveWords[i-1] = "Banana";
            //document.getElementById("myAnimation"+i.toString()).innerHTML = "Banana";
            //myMove(i);
            //return;
    
        }
        
        //if the current word does not match, unhighlight
        //if(value.localeCompare(userWord) != 0){
        if(value !== userWord){
            isMatch[i-1] = false;
            count++;
            /*if number of trues on
            count 4*/
            //if(isMatch[i-1] = true)
            //only entered when fiveWord array is looped through
            if(count == fiveWords.length){
                //userWord = letter; // previous assignment -- alec
                //reset value and word if there isn't a match after array is looped -- alec
                value = "";
                userWord = "";
                unhighlight();      //should unhighlight on invalid entries -- alec
                return;
            }
        }
        //if the current word is a match, highlight
        else {
            console.log("MATCH - " + userWord);
            //highlight the value at element "i" in the array
            dehighlight(); //does exactly what unhighlight function does but with a condition -- alec
            highlight(value, i);
            isMatch[i-1] = true;
            //return;
        }
    }
    
    //if theres even one word match, exit and wait for the next letter
    for(var i = 0; i < isMatch.length; i++){
        if(isMatch[i] == true){
            //match = fiveWords[i];
            return;
        } 
    }

    //if there is not match, reset userWord to nothing
    return;
 
}

///////////////////////////////////////////////////////
//////////////////// highlight word ///////////////////
///////////////////////////////////////////////////////
function highlight(part, i){
    document.getElementById("myAnimation"+i).innerHTML = fiveWords[i-1];
    var inputText = document.getElementById("myAnimation"+i);
    var innerHTML = inputText.innerHTML;
    var highlightedPart = innerHTML.substring(0, part.length);
    var restOfWord = innerHTML.substring(part.length, innerHTML.length);
    
    innerHTML = "<span class='highlight'>" + highlightedPart + "</span>" + restOfWord;
    inputText.innerHTML = innerHTML;
    
//    if(highlightedPart.localeCompare(fiveWords[i-1]) == 0){
//       document.getElementById("myAnimation"+i).innerHTML = fiveWords[i-1]; 
//    }
}


///////////////////////////////////////////////////////
//////////////////// un-highlight words ///////////////
///////////////////////////////////////////////////////
function unhighlight(){
    insertWords();
    //added to reset value variable -- alec;
    //value="";
    //userWord="";
}

///////////////////////////////////////////////////////
////////////////////check true //////////////////////// //i don't think this is used --alec
///////////////////////////////////////////////////////
///function for checking true
function checkTrue(matches) {
  return matches == true;
}