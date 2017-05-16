(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.importar, function(imp) {
                return (!filter.No          || imp.No.indexOf(filter.No) > -1)
                    && (!filter.Id_Curso    || imp.Id_Curso === filter.Id_Curso)
                    && (!filter.Curso_Presencial || imp.Curso_Presencial.indexOf(filter.Curso_Presencial) > -1)
                    &&(!filter.Id_Curso_Padre    || imp.Id_Curso_Padre.indexOf(filter.Id_Curso_Padre) > -1)
                    &&(!filter.Camp_Presencial   || imp.Camp_Presencial.indexOf(filter.Camp_Presencial) > -1)
                    &&(!filter.Campus_Presencial || imp.Campus_Presencial.indexOf(filter.Campus_Presencial) > -1)
                    &&(!filter.Matriculas   || imp.Matriculas.indexOf(filter.Matriculas) > -1)
                    
                                  
            });
        },
        insertItem: function(insertingImp) {
            this.importar.push(insertingImp);
        },
        updateItem: function(updatingImp) { },

        deleteItem: function(deletingImp) {
            var clientIndex = $.inArray(deletingImportar, this.importar);
            this.importar.splice(clientIndex, 1);
        }
    }; 

    window.db = db;
    db.importar = [
        {
            "No": 1,
            "Id_Curso": 7899 ,
            "Curso_Presencial":"ICAT 201620 - Presencial Grupo A - CFP Arequipa",
            "Id_Curso_Padre": 6888,
            "Camp_Presencial": 51,
            "Campus_Presencial":"CFP Arequipa",
            "Matriculas":502 
        },
		 {
            "No": 2,
            "Id_Curso": 7898 ,
            "Curso_Presencial":"ICAT 201620 - Presencial Grupo A - CFP Arequipa",
            "Id_Curso_Padre": 6889,
            "Camp_Presencial": 54,
            "Campus_Presencial":"CFP Arequipa",
            "Matriculas":509 
        },
		 {
            "No": 3,
            "Id_Curso": 7895 ,
            "Curso_Presencial":"ICAT 201620 - Presencial Grupo A - CFP Arequipa",
            "Id_Curso_Padre": 6888,
            "Camp_Presencial": 52,
            "Campus_Presencial":"CFP Arequipa",
            "Matriculas":509 
        },
		 {
            "No": 4,
            "Id_Curso": 7891 ,
            "Curso_Presencial":"ICAT 201620 - Presencial Grupo A - CFP Arequipa",
            "Id_Curso_Padre": 8776,
            "Camp_Presencial": 51,
            "Campus_Presencial":"CFP Arequipa",
            "Matriculas":507
        },
		{
            "No": 5,
            "Id_Curso": 789431 ,
            "Curso_Presencial":"ICAT 201620 - Presencial Grupo A - CFP Arequipa",
            "Id_Curso_Padre": 6233,
            "Camp_Presencial": 51,
            "Campus_Presencial":"CFP Arequipa",
            "Matriculas":507
        },
		 {
            "No": 6,
            "Id_Curso": 78931 ,
            "Curso_Presencial":"ICAT 201620 - Presencial Grupo A - CFP Arequipa",
            "Id_Curso_Padre": 6883,
            "Camp_Presencial": 51,
            "Campus_Presencial":"CFP Arequipa",
            "Matriculas":507
        },
		 {
            "No": 7,
            "Id_Curso": 7834 ,
            "Curso_Presencial":"ICAT 201620 - Presencial Grupo A - CFP Arequipa",
            "Id_Curso_Padre": 6855,
            "Camp_Presencial": 513,
            "Campus_Presencial":"CFP Arequipa",
            "Matriculas":543
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