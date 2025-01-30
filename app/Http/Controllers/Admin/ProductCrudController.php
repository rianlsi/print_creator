<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ZakekeController;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');


    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::addField([
            'name' => 'thumbnail', // The name of the column in the database
            'label' => 'Thumbnail', // The label for the form field
            'type' => 'upload', // The field type is upload
            'upload' => true, // Enable file upload
            'disk' => 'public', // Store files in the public disk (storage/app/public)
            'destination' => 'products', // Store the file in the products directory
        ]);
    }

        protected function store(Request $request)
        {
            $data = $request->all();

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $fileName = $file->getClientOriginalName(); // Get the original file name
                $file->storeAs('products', $fileName, 'public'); // Store the file with the original name
                $data['thumbnail'] = $fileName; // Store only the file name in the database
            }

            // Save the product
            $product = new Product($data);
            $product->save();

            // Redirect back to the list
            return redirect()->route('product.index');
    }
    protected function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('products', $fileName, 'public');
            $data['thumbnail'] = $fileName; // Store only the file name
        }

        $product->update($data);

        return redirect()->route('product.index');
    }



        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */




    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();


    }


}
