(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.admcourse, function(admncourse) {
                return (!filter.Zonal       || admncourse.Zonal.indexOf(filter.Zonal) > -1)
                    && (!filter.Camp        || admncourse.Camp === filter.Camp)
                    && (!filter.Campus      || admncourse.Campus.indexOf(filter.Campus) > -1)
                    &&(!filter.Administrador|| admncourse.Administrador.indexOf(filter.Administrador) > -1)
                    &&(!filter.ID_User_SV   || admncourse.ID_User_SV.indexOf(filter.ID_User_SV) > -1)
                    &&(!filter.PIDM_SINFO   || admncourse.PIDM_SINFO.indexOf(filter.PIDM_SINFO) > -1)
                    &&(!filter.Acciones     || admncourse.Acciones.indexOf(filter.Acciones) > -1)
                  
                                  
            });
        },
        insertItem: function(insertingAdmCourse) {
            this.admcourse.push(insertingAdmCourse);
        },
        updateItem: function(updatingAdm) { },

        deleteItem: function(deletingAdm) {
            var clientIndex = $.inArray(deletingAdmcourse, this.admcourse);
            this.admcourse.splice(clientIndex, 1);
        }
    }; 

    window.db = db;

    db.admcourse = [
        {
            "Zonal":"ZONAL AREQUIPA PUNO",
            "Camp":"51A",
            "Campus":"AQP-UFP Automotores",
            "ID_User_SV":137,
            "PIDM_SINFO":5,
          
        },
		{
            "Zonal":"ZONAL AREQUIPA PUNO",
            "Camp":"51A",
            "Campus":"AQP-UFP Automotores",
            "ID_User_SV":137,
            "PIDM_SINFO":6,
          
        },
		{
            "Zonal":"ZONAL AREQUIPA PUNO",
            "Camp":"51A",
            "Campus":"AQP-UFP Automotores",
            "ID_User_SV":137,
            "PIDM_SINFO":8,
          
        },
		{
            "Zonal":"ZONAL AREQUIPA PUNO",
            "Camp":"51A",
            "Campus":"AQP-UFP Automotores",
            "ID_User_SV":137,
            "PIDM_SINFO":2,
          
        },
		{
            "Zonal":"ZONAL AREQUIPA PUNO",
            "Camp":"51A",
            "Campus":"AQP-UFP Automotores",
            "ID_User_SV":137,
            "PIDM_SINFO":4,
          
        }      
    ];


   /*

    db.countries = [
        { Name: "", Id: 0 },
        { Name: "United States", Id: 1 },
        { Name: "Canada", Id: 2 },
        { Name: "United Kingdom", Id: 3 },
        { Name: "France", Id: 4 },
        { Name: "Brazil", Id: 5 },
        { Name: "China", Id: 6 },
        { Name: "Russia", Id: 7 }
    ]; 

    */
   

}());