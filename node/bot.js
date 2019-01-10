var twit = require('twit');
var config = require('./config.js');
var fs = require('fs');
var request = require('request');
const GoogleImages = require('google-images');
var ToneAnalyzerV3 = require('watson-developer-cloud/tone-analyzer/v3');
const client = new GoogleImages("015372784502831989082:doqagfo-ueo","AIzaSyCJZuidEYLUtcWzVmmlv6PGor7j9M-6BZ4");
var toneAnalyzer = new ToneAnalyzerV3({
    username: '70a8ef88-bf71-4c44-9248-c6b7b011ce5e',
    password: 'JvTTaCWwzHgx',
    version_date: '2016-05-19'
});

const production= false ;


var Twitter = new twit(config);

// find latest tweet according the query 'q' in params
var retweet = function() {
    var params = {
        q: '#Chocolate, #chocolate',  // REQUIRED
        result_type: 'recent',
        lang: 'en'
    }
    // for more parameters, see: https://dev.twitter.com/rest/reference/get/search/tweets

    Twitter.get('search/tweets', params, function(err, data) {
        // if there no errors
        if (!err) {
            // grab ID of tweet to retweet
            var retweetId = data.statuses[0].id_str;
            var tweetText = data.statuses[0].text;
            //start bot tweet proc
            toneAnalyzeTweet(tweetText).then(getImageUrl).then(function(imageUrl){
                request.post("localhost/faceafeka/bot.html", {image_url: imageUrl, tweet: tweetText}) ;
                console.log("Image url:", imageUrl) ;
            }).catch(function(err) {console.log(err)}) ;

            // Tell TWITTER to retweet
            // Twitter.post('statuses/retweet/:id', {id: retweetId}, function(err, response) {
            //     if (response) {
            //         console.log('Retweeted!!!');
            //     }
            //     // if there was an error while tweeting
            //     if (err) {
            //         console.log('Something went wrong while RETWEETING... Duplication maybe...');
            //     }
            // });
        }
        // if unable to Search a tweet
        else {
            console.log('Something went wrong while SEARCHING...');
        }
    });
};

var botTweet = function (tweetText) {
    var max = toneAnalyzeTweet(tweetText);

};
var toneAnalyzeTweet = function (tweetText) {
    return new Promise(function(resolve,reject){
        toneAnalyzer.tone({text: tweetText}, function(err,response) {
            console.log("response",response) ;
            if (err){
                console.log("tone analyzer error :", err);
            }
            else {
                var cats = response.document_tone.tone_categories;
                var maxSentiment;
                var maxScore = 0;

                cats.forEach(function (cat) {
                    cat.tones.forEach(function (tone) {
                        console.log(" %s: %s", tone.tone_name, tone.score);
                        if(tone.score > maxScore){
                            maxScore = tone.score;
                            maxSentiment = tone.tone_name;
                        }
                    })
                });
                console.log(maxSentiment);
                resolve(maxSentiment);
            }
        });
    });

};


var getImageUrl = function(maxSentiment){
    return new Promise(function(resolve,reject) {
        client.search(maxSentiment).then(function(images){
            var imageURL=images[0].url ;
            console.log("Image url :", imageURL) ;
            if(production){
                resolve(imageURL, config.dest_server, imageTEXT) ;
            }else {
                resolve(imageURL) ;
            }
        }).catch(function(e){
            reject(e) ;
        });
    })
};


// grab & retweet as soon as program is running...
retweet();
//client.search("anger").then(function(images){
//     console.log("Searching test: ",images);
//     console.log("Image url: ", images[0].url) ;
// });

console.log('Start retweet');
// retweet in every 50 minutes
//setInterval(retweet, 30000);