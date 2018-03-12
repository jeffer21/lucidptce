/**
 * Created by AlanJoseph on 3/9/2018.
 */
function mobileNav(){
    var x = document.getElementById('mobile-menu').style.left;
    if (x === "" || x ==="-100%"){
        document.getElementById('mobile-menu').style.left = 0;
        document.getElementById('mobile-menu-container').style.display = "block";
        document.getElementById('page').classList.add("blur");


    }else{
        document.getElementById('mobile-menu').style.left = "-100%";
        document.getElementById('page').classList.remove("blur");
        document.getElementById('mobile-menu-container').style.display = "none";
    }


}
function mobileSearch(){
    console.log('ready');
    var x = document.getElementById('mobile-search').style.display;
    console.log(x)
    if (x === "" || x ==="none"){
        document.getElementById('mobile-search').style.display = "block";
    }else{
        document.getElementById('mobile-search').style.display = "none";
    }
}

// console.log('start test');
// var x = document.getElementById('mobile-menu').classList.value;

// if (x === "hidden"){
// 	document.getElementById('mobile-menu').classList.remove("hidden");
// 	console.log('open');
// }else{
// 	document.getElementById('mobile-menu').classList.add("hidden");
// 	console.log('close');
// }