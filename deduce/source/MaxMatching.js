var boys = ['Peter', 'Allen', 'Jhon', 'Mike', 'Anthony', 'Austin', 'Hugo', 'Howard', 'Jimmy', 'Paul'];
var girls = ['Mary', 'Alice', 'Cindy', 'Janet', 'Natasha', 'Peggy', 'Sarah', 'Zoey', 'Mandy', 'Judy'];
var boys_points = [];
var girls_points = [];
var favorites = [];
for (var boy = 0; boy < boys.length; boy++) {
    favorites[boy] = [];
    //风流指数
    var romantic = Math.floor(Math.random() * 3 + 1);

    //女孩总数
    var girls_total = girls.length;
    var favorite_girls = new Set();
    for (var i = 0; i < romantic; i++) {
        var select = parseInt(girls_total * Math.random());
        while (favorite_girls.has(select)) {
            select = parseInt(girls_total * Math.random());
        }
        favorite_girls.add(select);
    }
    for (var girl = 0; girl < girls.length; girl++) {
        if (favorite_girls.has(girl)) {
            favorites[boy][girl] = true;
        } else {
            favorites[boy][girl] = false;
        }
    }
}
var match = {};
var max_match = 0;
var search;
for (var boy = 0; boy < boys.length; boy++) {
    search = new Set();
    if (find_augment_path(boy)) {
        max_match += 1;
    }
};
function find_augment_path(boy) {
    for (var girl = 0; girl < girls.length; girl++) {
        if (favorites[boy][girl] && !search.has(girl)) {
            search.add(girl);
            if (match[girl] == null || find_augment_path(match[girl])) {
                match[girl] = boy;
                return true;
            }
        }
    };
    return false;
}
