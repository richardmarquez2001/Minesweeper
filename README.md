# Minesweeper

A recreation of minesweeper using JS/JQuery, HTML and CSS.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Installing

Installation is straight forward. Download everything into the same folder.

## Running the tests

To test the program works, you should:
* change rowNum and colNum to any size you desire
```
let rowNum = 10;
let colNum = 10;
```
* Comment out showBoard() if you don't want to see every square.
```
// showBoard();
```

* randomly click until a bomb is hit.

## Built With

* [JQuery](https://api.jquery.com/) - Library used for manipulating HTML/CSS elements through JS.

## Versioning
(Currently on version 1.0)

1.0:
* First version of the game, added functionality for a single game. 
* Game can be ran once, reload to restart the game. alert popups indicate whether you won or lost.

## Author

* **Richard Marquez** - *Main Author* 

## Acknowledgments

* Shoutout to Alain Nguyen for introducing to me the floodfill algorithm, which ended up being used in this project.
