'use strict';

module.exports = function(app) {
    app.get('/', function(req, res) {
        res.render('pages/index');
    });

    app.get('/about', function(req, res) {
        res.render('pages/about');
    });

    app.get('/course/cursos_bdirecto', function(req, res) {
        res.render('pages/cursos_detallados');
    });

    app.get('/course/cursos_admin', function(req, res) {
        res.render('pages/administracion_general');
    });

    app.get('/grade/pondera01', function(req, res) {
        res.render('pages/ponderaciones');
    });

    app.get('/grade/acta_notas', function(req, res) {
        res.render('pages/acta_notas_sinfo');
    });

    app.get('/grade/acta_notas02', function(req, res) {
        res.render('pages/acta_notas_sinfo_fusionadas');
    });
};