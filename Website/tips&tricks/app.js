
if ($("#favWorkout").val() == "none") {
  search1 = "How to make a workout program";
}else{
  search1 = $("#favWorkout").val() + " Workout Exercise";
}

if ($("#leastFavWorkout").val() == "none") {
  search2 = "How to start exercising";
}else{
  search2 = $("#leastFavWorkout").val() + " Workout Exercise"; 
}

if ($("#favCategory").val() == "none") {
  search3 = "Exercise Advice"
}else{
  search3 = $("#favCategory").val() + " Workout Exercise";  
}

if ($("#leastFavCategory").val() == "none") {
  search4 = "beginner exercise routines"
}else{
  search4 = $("#leastFavCategory").val() + " Workout Exercise";    
}

var searchfields = [search1,search2,search3,search4];
$("#results").html("");

console.log(searchfields);
function tplawesome(e,t){res=e;for(var n=0;n<t.length;n++){res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){return t[n][r]})}return res}

function googleApiClientReady(){
  gapi.client.setApiKey('AIzaSyA5FedqGFpoXAHMWWX9mOpwsPzYmw13nZQ');
  gapi.client.load('youtube', 'v3', function() {
    for (var i = 0; i < searchfields.length; i++){
      search(searchfields[i]);
    }
  });
}
function search(input) {
  var request = gapi.client.youtube.search.list({
    part: "snippet",
    type: "video",
    q: input,
    maxResults: 1,
    order: "viewCount",
    publishedAfter: "2015-01-01T00:00:00Z",
    videoEmbeddable: true
});
 // execute the request
request.execute(function(response) {
  var results = response.result;
  $.each(results.items, function(index, item) {
    $.get("tpl/item.html", function(data) {
      $("#results").append(tplawesome(data, [{"title":item.snippet.title, "videoid":item.id.videoId}]));
    });
  });
  resetVideoHeight();
});
  $(window).on("resize", resetVideoHeight);
} 
function resetVideoHeight() {
    $(".video").css("height", $("#results").width() * 9/16);
}
