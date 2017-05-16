(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.evaluaciones, function(ponderaciones) {
                return (!filter.Tareas || ponderaciones.Ponderacion.indexOf(filter.Tareas) > -1)
                    && (!filter.Ponderación_HA || ponderaciones.Ponderación_HA> -1)
                    &&(!filter.Unidad || ponderaciones.Unidad.indexOf(filter.Unidad) > -1)
            });
        },
        insertItem: function(insertingCourse) {
            this.evaluaciones.push(insertingCourse);
        },
        updateItem: function(updatingCourse) { },

        deleteItem: function(deletingCourse) {
            var clientIndex = $.inArray(deletingCourses, this.evaluaciones);
            this.evaluaciones.splice(clientIndex, 1);
        }
    }; 

    window.db = db;

    db.evaluaciones = [
        {
            "Tareas": 1,
            "Ponderación_HA": 'Texto',
            "Unidad": 1,
        },
        {
            "Tareas": 2,
            "Ponderación_HA": 'Texto',
            "Unidad": 1,
        },
        {
            "Tareas": 3,
            "Ponderación_HA": 'Texto',
            "Unidad": 1,
        }
        
    ];

}());