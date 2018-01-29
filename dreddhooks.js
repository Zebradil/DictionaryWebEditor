hooks = require('hooks');

stash = {};

hooks.after('/api/v1/dictionaries > Get list of the all available dictionaries > 200 > application/json',
    function (transaction) {
        stash.preparedDictionaryId = JSON.parse(transaction.real.body).pop().id;
    });

hooks.after('/api/v1/dictionaries > Create new dictionary > 201 > application/json',
    function (transaction) {
        stash.newDictionaryId = JSON.parse(transaction.real.body).id;
    });

hooks.before('/api/v1/dictionaries/{dictionaryId} > Get the dictionary by its id > 200 > application/json',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.newDictionaryId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });

hooks.before('/api/v1/dictionaries/{dictionaryId} > Update data of the dictionary > 200 > application/json',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.preparedDictionaryId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });

hooks.before('/api/v1/dictionaries/{dictionaryId} > Delete the dictionary > 204',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.newDictionaryId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });

hooks.before('/api/v1/dictionaries/{dictionaryId}/articles > Get list of the all available articles of particular dictionary > 200 > application/json',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.preparedDictionaryId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });

hooks.after('/api/v1/dictionaries/{dictionaryId}/articles > Get list of the all available articles of particular dictionary > 200 > application/json',
    function (transaction) {
        stash.preparedArticleId = JSON.parse(transaction.real.body).pop().id;
    });

hooks.before('/api/v1/dictionaries/{dictionaryId}/articles > Create new article > 201 > application/json',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.preparedDictionaryId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });

hooks.after('/api/v1/dictionaries/{dictionaryId}/articles > Create new article > 201 > application/json',
    function (transaction) {
        stash.newArticleId = JSON.parse(transaction.real.body).id;
    });

hooks.before('/api/v1/articles/{articleId} > Get the article by its id > 200 > application/json',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.newArticleId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });

hooks.before('/api/v1/articles/{articleId} > Update data of the article > 200 > application/json',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.newArticleId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });

hooks.before('/api/v1/articles/{articleId} > Delete the article > 204',
    function (transaction) {
        transaction.fullPath = transaction.fullPath.replace('42', stash.newArticleId);
        transaction.request.uri = transaction.fullPath;
        hooks.log(transaction.fullPath);
    });


/**
 info: /api/v1/dictionaries > Get list of the all available dictionaries > 200 > application/json
 info: /api/v1/dictionaries/{dictionaryId} > Get the dictionary by its id > 200 > application/json
 info: /api/v1/dictionaries/{dictionaryId} > Update data of the dictionary > 200 > application/json
 info: /api/v1/dictionaries/{dictionaryId} > Delete the dictionary > 204
 info: /api/v1/dictionaries/{dictionaryId}/articles > Create new article > 201 > application/json
 info: /api/v1/dictionaries/{dictionaryId}/articles > Get list of the all available articles of particular dictionary > 200 > application/json
 info: /api/v1/articles/{articleId} > Get the article by its id > 200 > application/json
 info: /api/v1/articles/{articleId} > Update data of the article > 200 > application/json
 info: /api/v1/articles/{articleId} > Delete the article > 204
 */
