$(function() {
    var DeleteCell = Backgrid.Cell.extend({
        template: _.template('<button class="btn btn-danger"><i class="fa fa-trash"></i></button>'),
        events: {
            "click": "deleteRow"
        },
        deleteRow: function(e) {
            e.preventDefault();
            this.model.collection.remove(this.model);
        },
        render: function() {
            this.$el.html(this.template());
            this.delegateEvents();
            return this;
        }
    });
    var Territory = Backbone.Model.extend({});
    var columnss = [{
        name: "id", // The key of the model attribute
        label: "ID", // The name to display in the header
        editable: false, // By default every cell in a column is editable, but *ID* shouldn't be
        // Defines a cell type, and ID is displayed as an integer without the ',' separating 1000s.
        cell: Backgrid.IntegerCell.extend({
            orderSeparator: ''
        })
    }, {
        name: "kode",
        label: "Kode",
        // The cell type can be a reference of a Backgrid.Cell subclass, any Backgrid.Cell subclass instances like *id* above, or a string
        cell: "string" // This is converted to "StringCell" and a corresponding class in the Backgrid package namespace is looked up
    }, {
        name: "nama",
        label: "Nama Rekening",
        cell: "string" // An integer cell is a number cell that displays humanized integers
    }, {
        name: "keterangan",
        label: "Keterangan",
        cell: "string" // An integer cell is a number cell that displays humanized integers
    }, {
        name: "id",
        label: "Action",
        cell: DeleteCell
    }, ];
    var PageableTerritories = Backbone.PageableCollection.extend({
        model: Territory,
        url: $("#koderekening-grid").attr('data-remote'),
        state: {
            pageSize: 10
        },
        mode: "client" // page entirely on the client side
    });
    var pageableTerritories = new PageableTerritories();
    // Set up a grid to use the pageable collection
    var pageableGrid = new Backgrid.Grid({
        columns: columnss,
        collection: pageableTerritories,
    });
    // Render the grid
    var $gridObj = $("#koderekening-grid");
    $gridObj.append(pageableGrid.render().el)
        // Initialize the paginator
    var paginator = new Backgrid.Extension.Paginator({
        collection: pageableTerritories
    });
    // Render the paginator
    $gridObj.after(paginator.render().el);
    // Initialize a client-side filter to filter on the client
    // mode pageable collection's cache.
    // Fetch some data
    pageableTerritories.fetch({
        reset: true
    });
});