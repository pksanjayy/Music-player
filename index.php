<?php
require_once('config/db.php');
$query = "SELECT * FROM beats";
$result = mysqli_query($con, $query);
$beatsArray = [];

while ($row = mysqli_fetch_assoc($result)) {
    $beatsArray[] = $row;
}

mysqli_free_result($result);
mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Main</title>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&amp;display=swap">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script><link rel="stylesheet" href="./style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.3.1/howler.min.js"></script>

</head>
<body >
 

  <div class="sidebar">
    <div class="logo">
      <a href="index.php">
        <img src="https://storage.googleapis.com/pr-newsroom-wp/1/2018/11/Spotify_Logo_CMYK_Green.png" alt="Logo" />
      </a>
    </div>

    <div class="navigation">
      <ul>
        <li>
          <a href="index.php">
            <span class="fa fa-home"></span>
            <span>Home</span>
          </a>
        </li>


        <li>
          <a href="playlist.php">
            <span class="fa fas fa-book"></span>
            <span>Your Library</span>
          </a>
        </li>
        
        <li>
          <a href="likedsong.php">
            <span class="fa fas fa-heart"></span>
            <span>Liked Songs</span>
          </a>
        </li>
      </ul>
    </div>


    <div class="policies">
      <ul>
        <li>
          <a href="#"></a>
        </li>
        <li>
          <a href="#"></a>
        </li>
      </ul>
    </div>
  </div>




  
  <div class="main-container">
    <div class="topbar">
      <div class="heading">
        <h1 id="greeting" style="color:white;position: relative;right:10%;"></h1>
        </div>
      <div class="prev-next-buttons">

      </div>

      <div class="navbar">
        <ul>
          <li>
            <a href="#"></a>
          </li>
          <li>
            <a href="#"></a>
          </li>
          <li class="divider">|</li>

        </ul>
        
      </div>
    </div>



    <div class="grid">
  <a href="likedsong.php" class="box">
    <img src="https://preview.redd.it/rnqa7yhv4il71.jpg?width=640&crop=smart&auto=webp&s=819eb2bda1b35c7729065035a16e81824132e2f1" alt="Image">
    <h4>Liked Songs</h4>
    <div class="play">
      <span class="fa fa-play"></span>
    </div>
  </a>
  <a href="dailymix.php" class="box">
    <img src="https://images.unsplash.com/photo-1567787609897-efa3625dd22d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bXVzaWMlMjB3YWxscGFwZXJ8ZW58MHx8MHx8fDA%3D&w=1000&q=80" alt="Image">
    <h4>Daily mix</h4>
    <div class="play">
      <span class="fa fa-play"></span>
    </div>
  </a>
  <a href="playlist.php" class="box">
    <img src="https://www.hypebot.com/wp-content/uploads/2020/07/discover-weekly.png" alt="Image">
    <h4>Discover weekly</h4>
    <div class="play">
      <span class="fa fa-play"></span>
    </div>
  </a>
</div>
 

    </div>


<br>

 
	  





<table style="width:100%;">
<tr>
  <td>
    <div class="heading">
      <h1 style="margin-bottom: 0;font-family: 'Montserrat', sans-serif;">Made for you</h1>


      </div>
      <div class="grid-container" id="gridContainer"></div>
  </td>
</tr>


<tr>
  <td>
    <div class="heading">
      <h1 style="margin-bottom: 0;font-family: 'Montserrat', sans-serif;">Recently played</h1>


      </div>
      <div class="grid-container" id="gridContainer1"></div>
      <br>
      <br>
      <br>
  </td>
</tr>


<tr>
  <td>
    <div id="recentlyPlayedContainer"></div>
  </td>
</tr>
</table>



	<p id="sliderValue">50</p>

	<div class="player">

		<div class="circle">
			<div class="artist-name"></div>
			<div class="music-name"></div>
			<div class="circ"></div>

			<div id="thumbnail" class="thumbnail"></div>

		</div>
		<div class="player-control">
			<div class="slide-container">
				<input type="range" min="0" step="1" max="100" value="50" class="slider" id="slider">
			</div>
			<div class="placement">
				<div class="heart"></div>
			</div>
			
	    <a href="#" class="speaker">
		   <span></span>
	    </a>
			<div class="player-track">

				<i id="prev" class="prev-btn fas fa-backward"></i>
				<i id="play" class="play-btn fas fa-play"></i>
				<i id="next" class="next-btn fas fa-forward"></i>


				<center>
				<div class="progress-bar">
					<div class="fillBar"></div>
				</div>
				</center>

					<div class="time"></div>

			</div>

		</div>

	</div>


  
</body>
<!-- partial -->
  <script>
    var beatpack = <?php echo json_encode($beatsArray); ?>;
    console.log(beatpack);
    
var snum=0;
var no=0;
var result1 = 0;
			var randomBeatpack = 0;
			var randomSongs = 0;
			var randomArtists = 0;
			var shuffledindexes=0;
      
$(document).ready(function () {
	var playing = false,
		artistname = $(".artist-name"),
		musicName = $(".music-name"),
		time = $(".time"),
		fillBar = $(".fillBar");

	var song = new Audio();
	var CurrentSong = 0;
	window.onload = load();


	function load() {
		
		
		function createArray(maxValue) {
			var arr = [];
			for (var i = 0; i <= maxValue; i++) {
			  arr.push(i);
			}
			return arr;
		  }

		  var indexes=createArray(beatpack.length)
		  console.log(indexes);
	  
		  function getRandomNumber(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		  }
	  
		  function shuffleArray(array, array1, array2, array3) {
			var currentIndex = array.length, temporaryValue, randomIndex;
	  
			while (0 !== currentIndex) {
			  randomIndex = Math.floor(Math.random() * currentIndex);
			  currentIndex -= 1;
	  
			  temporaryValue = array[currentIndex];
			  array[currentIndex] = array[randomIndex];
			  array[randomIndex] = temporaryValue;
	  
			  temporaryValue = array1[currentIndex];
			  array1[currentIndex] = array1[randomIndex];
			  array1[randomIndex] = temporaryValue;
	  
			  temporaryValue = array2[currentIndex];
			  array2[currentIndex] = array2[randomIndex];
			  array2[randomIndex] = temporaryValue;
			  
			  temporaryValue = array3[currentIndex];
			  array3[currentIndex] = array3[randomIndex];
			  array3[randomIndex] = temporaryValue;
			  
			}
	  
			return [array, array1, array2,array3];
		  }

		  function getRandomImages() {
			var result = shuffleArray(beatpack, beatpack.map(item => item.name), beatpack.map(item => item.artist),indexes);
			var shuffledBeatpack = result[0];
			var shuffledSongs = result[1];
			var shuffledArtists = result[2];
			var shuffledindexes=result[3];
			return [shuffledBeatpack.slice(0, 5), shuffledSongs.slice(0, 5), shuffledArtists.slice(0, 5),shuffledindexes];
		  }





	  
		  function displayRandomImages() {
			var gridContainer = document.getElementById("gridContainer");
			gridContainer.innerHTML = "";
	  
			result1 = getRandomImages();
			randomBeatpack = result1[0];
			randomSongs = result1[1];
			randomArtists = result1[2];
			shuffledindexes=result1[3];
	  
			randomBeatpack.forEach(function (item, index) {
			  var gridBox = document.createElement("div");
			  gridBox.className = "grid-box";
	  
			  var list = document.createElement("div");
			  list.className = "list";
	  
			  var itemDiv = document.createElement("div");
			  itemDiv.className = "item";

			  itemDiv.addEventListener("click", function() {
				var count = index;

				playSong(count);
			  });
			  
	  
			  var imageContainer = document.createElement("div");
			  imageContainer.className = "thumb";
			  imageContainer.style.backgroundImage = item.thumbnail;
	  
			  var playDiv = document.createElement("div");
			  playDiv.className = "play";
	  
			  var playIcon = document.createElement("span");
			  playIcon.className = "fa fa-play";
	  
			  var songName = document.createElement("h4");
			  songName.textContent = randomSongs[index];
	  
			  var artistName = document.createElement("p");
			  artistName.textContent = randomArtists[index];
	  
			  playDiv.appendChild(playIcon);
			  itemDiv.appendChild(imageContainer);
			  itemDiv.appendChild(playDiv);
			  itemDiv.appendChild(songName);
			  itemDiv.appendChild(artistName);
			  list.appendChild(itemDiv);
			  gridBox.appendChild(list);
			  gridContainer.appendChild(gridBox);
			});
		  }
	  
		  displayRandomImages();



      function getRandomImages() {
			var result = shuffleArray(beatpack, beatpack.map(item => item.name), beatpack.map(item => item.artist),indexes);
			var shuffledBeatpack = result[0];
			var shuffledSongs = result[1];
			var shuffledArtists = result[2];
			var shuffledindexes=result[3];
			return [shuffledBeatpack.slice(0, 5), shuffledSongs.slice(0, 5), shuffledArtists.slice(0, 5),shuffledindexes];
		  }
	  
		  function displayRandomImages1() {
			var gridContainer1 = document.getElementById("gridContainer1");
			gridContainer1.innerHTML = "";
	  

	  
			randomBeatpack.forEach(function (item, index) {
			  var gridBox = document.createElement("div");
			  gridBox.className = "grid-box";
	  
			  var list = document.createElement("div");
			  list.className = "list";
	  
			  var itemDiv = document.createElement("div");
			  itemDiv.className = "item";

			  itemDiv.addEventListener("click", function() {
				var count = index;

				playSong(count);
			  });
			  
	  
			  var imageContainer = document.createElement("div");
			  imageContainer.className = "thumb";
			  imageContainer.style.backgroundImage = item.thumbnail;
	  
			  var playDiv = document.createElement("div");
			  playDiv.className = "play";
	  
			  var playIcon = document.createElement("span");
			  playIcon.className = "fa fa-play";
	  
			  var songName = document.createElement("h4");
			  songName.textContent = randomSongs[index];
	  
			  var artistName = document.createElement("p");
			  artistName.textContent = randomArtists[index];
	  
			  playDiv.appendChild(playIcon);
			  itemDiv.appendChild(imageContainer);
			  itemDiv.appendChild(playDiv);
			  itemDiv.appendChild(songName);
			  itemDiv.appendChild(artistName);
			  list.appendChild(itemDiv);
			  gridBox.appendChild(list);
			  gridContainer1.appendChild(gridBox);
			});
		  }
	  
		  displayRandomImages1();




		var currentDate = new Date();
		var currentHour = currentDate.getHours();
	  
		var greeting;
	  
		if (currentHour >= 5 && currentHour < 12) {
		  greeting = "Good morning";
		} else if (currentHour >= 12 && currentHour < 18) {
		  greeting = "Good afternoon";
		} else if (currentHour >= 18 && currentHour < 24) {
		  greeting = "Good evening";
		} else {
		  greeting = "Good night";
		}
	  
		artistname.html(beatpack[CurrentSong].name);
		musicName.html(beatpack[CurrentSong].artist);
		song.src = beatpack[CurrentSong].src;
	  
		$("#greeting").html(greeting);
	  }
    function displayRandomImages1() {
			var gridContainer1 = document.getElementById("gridContainer1");
			gridContainer1.innerHTML = "";
	  

	  
			randomBeatpack.forEach(function (item, index) {
			  var gridBox = document.createElement("div");
			  gridBox.className = "grid-box";
	  
			  var list = document.createElement("div");
			  list.className = "list";
	  
			  var itemDiv = document.createElement("div");
			  itemDiv.className = "item";

			  itemDiv.addEventListener("click", function() {
				var count = index;
        var songIndex = beatpack.findIndex(function(item) {
  return item.name === randomSongs[count];
});
				playSong(songIndex);
			  });
			  
	  
			  var imageContainer = document.createElement("div");
			  imageContainer.className = "thumb";
			  imageContainer.style.backgroundImage = item.thumbnail;
	  
			  var playDiv = document.createElement("div");
			  playDiv.className = "play";
	  
			  var playIcon = document.createElement("span");
			  playIcon.className = "fa fa-play";
	  
			  var songName = document.createElement("h4");
			  songName.textContent = randomSongs[index];
	  
			  var artistName = document.createElement("p");
			  artistName.textContent = randomArtists[index];
	  
			  playDiv.appendChild(playIcon);
			  itemDiv.appendChild(imageContainer);
			  itemDiv.appendChild(playDiv);
			  itemDiv.appendChild(songName);
			  itemDiv.appendChild(artistName);
			  list.appendChild(itemDiv);
			  gridBox.appendChild(list);
			  gridContainer1.appendChild(gridBox);
			});
		  }

	function playSong(CurrentSong) {
 



    $(".heart").removeClass("is-active");
		artistname.html(beatpack[CurrentSong].name);
		musicName.html(beatpack[CurrentSong].artist);
		song.src = beatpack[CurrentSong].src;
		song.play();
	
		$("#thumbnail").css("background-image", beatpack[CurrentSong].thumbnail);
		$("#play").addClass("fa-pause");
		$("#play").removeClass("fa-play");
		$("#thumbnail").addClass("active");
		$(".player-track").addClass("active");
    snum=CurrentSong;
    randomBeatpack.unshift(beatpack[snum]);
    randomSongs.unshift(beatpack[snum].name);
    randomArtists.unshift(beatpack[snum].artist);
   shuffledindexes.unshift(snum);

  // Remove the fifth element from the arrays
  randomBeatpack.splice(5, 1);
  randomSongs.splice(5, 1);
  randomArtists.splice(5, 1);
  shuffledindexes.splice(5, 1); 
  console.log(randomBeatpack);
  no=no+1;
  displayRandomImages1();
	}


	song.addEventListener("timeupdate", function () {
		var position = (100 / song.duration) * song.currentTime;
		var current = song.currentTime;
		var duration = song.duration;
		var durationMinute = Math.floor(duration / 60);
		var durationSecond = Math.floor(duration - durationMinute * 60);
		var durationLabel = durationMinute + ":" + durationSecond;
		currentSecond = Math.floor(current);
		currentMinute = Math.floor(currentSecond / 60);
		currentSecond = currentSecond - currentMinute * 60;
		// currentSecond = (String(currentSecond).lenght > 1) ? currentSecond : ( String("0") + currentSecond );
		if (currentSecond < 10) {
			currentSecond = "0" + currentSecond;
		}
		var currentLabel = currentMinute + ":" + currentSecond;
		var indicatorLabel = currentLabel + " / " + durationLabel;

		fillBar.css("width", position + "%");

		$(".time").html(indicatorLabel);
	});

	$("#play").click(function playOrPause() {
		if (song.paused) {
			song.play();
			playing = true;
			$("#play").addClass("fa-pause");
			$("#play").removeClass("fa-play");
			$("#thumbnail").addClass("active");
			$(".play-btn:before").css("padding-left", 300);

			document.getElementsByClassName("play-btn")[0].classList.add("pause-btn");
			document.getElementsByClassName("play-btn")[0].classList.remove("play-btn");
		} else {
			song.pause();
			playing = false;
			$("#play").removeClass("fa-pause");
			$("#play").addClass("fa-play");
			$("#thumbnail").removeClass("active");

			document.getElementsByClassName("pause-btn")[0].classList.add("play-btn");
			document
				.getElementsByClassName("pause-btn")[0]
				.classList.remove("pause-btn");
		}
	});


	$("#prev").click(function prev() {
		CurrentSong--;
		if (CurrentSong < 0) {
			CurrentSong = beatpack.length - 1;
		}
		playSong(CurrentSong);

	});
	$("#mute").click(function prev() {
		song.volume=0;
	});

	$("#next").click(function next() {
		CurrentSong++;
		if (CurrentSong == beatpack.length) {
			CurrentSong = 0;
		}
		playSong(CurrentSong);
	});

	

	
    var slider = document.getElementById("slider");
    var sliderValue = document.getElementById("sliderValue");

    sliderValue.innerHTML = slider.value;

    slider.oninput = function() {
      sliderValue.innerHTML = this.value;
	  song.volume=this.value/100;
    };

    $(function() {
  $(".heart").on("click", function() {
    $(this).toggleClass("is-active");


    var songId = snum;
    var songTitle = beatpack[snum].name;
    var artist = beatpack[snum].artist;


    var id=snum;
    var name=beatpack[snum].name;
    var artist=beatpack[snum].artist;
    var src=beatpack[snum].src;
    var thumbnail=beatpack[snum].thumbnail;



    $.ajax({
      url: "add_row.php", 
      method: "POST",
      data: {
        id: id,
        name:name,
        artist: artist,
        src:src,
        thumbnail:thumbnail
      },
      success: function(response) {
        console.log("Song added to liked_songs table");
      },
      error: function(xhr, status, error) {
        console.error("Error adding song to liked_songs table:", error);
      }
    });
  });
});


$('.speaker').click(function(e) {
  e.preventDefault();

  $(this).toggleClass('mute');

  if ($(this).hasClass('mute')) {

    song.volume=0;

  } else {

    song.volume=0.5;

  }
});

	

});






  </script>

</body>
</html>
