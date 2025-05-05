

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
	  
			var result1 = getRandomImages();
			var randomBeatpack = result1[0];
			var randomSongs = result1[1];
			var randomArtists = result1[2];
			var shuffledindexes=result1[3];
	  
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
	  

	function playSong(CurrentSong) {
		artistname.html(beatpack[CurrentSong].name);
		musicName.html(beatpack[CurrentSong].artist);
		song.src = beatpack[CurrentSong].src;
		song.play();
	
		$("#thumbnail").css("background-image", beatpack[CurrentSong].thumbnail);
		$("#play").addClass("fa-pause");
		$("#play").removeClass("fa-play");
		$("#thumbnail").addClass("active");
		$(".player-track").addClass("active");
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





