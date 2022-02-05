<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Producto;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['show_products','register']]);
    }

    public function reg_product(){
        $data = request(['nombre','precio','categoria','descripcion','marca','stockMin',
            'stockMax','stockExistente']);
        try {
            $producto['nombre'] = $data['nombre'];
            $producto['precio'] = $data['precio'];
            $producto['categoria'] = $data['categoria'];
            $producto['descripcion'] = $data['descripcion'];
            $producto['marca'] = $data['marca'];
            $producto['stockMin'] = $data['stockMin'];
            $producto['stockMax'] = $data['stockMax'];
            $producto['stockExistente'] = $data['stockExistente'];
            $_producto = new Producto($producto);
            $_producto->save();

            $response = ['result' => 'success','msg' => 'Registro exitoso'];
            return $response;

        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function show_product(){
        try{
            $identified = request(['id']);
            $products = Producto::findOrFail($identified);
            $response = ['result' => 'success','data' => $products];
            return $response;
        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function show_products(){
        try{
            $products = Producto::all();
            for ($i=0; $i < count($products); $i++){
                $lista[] = $products[$i];
            }
            $response = ['result' => 'success','data' => $lista];
            return $response;
        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function update_product(){
        $data = request(['id','nombre','precio','categoria','descripcion','marca','stockMin',
            'stockMax','stockExistente']);
        try {
            $producto['nombre'] = $data['nombre'];
            $producto['precio'] = $data['precio'];
            $producto['categoria'] = $data['categoria'];
            $producto['descripcion'] = $data['descripcion'];
            $producto['marca'] = $data['marca'];
            $producto['stockMin'] = $data['stockMin'];
            $producto['stockMax'] = $data['stockMax'];
            $producto['stockExistente'] = $data['stockExistente'];
            $_producto = Producto::findOrFail($data['id']);
            $_producto->update($producto);

            $response = ['result' => 'success','msg' => 'Edición exitosa'];
            return $response;

        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function delete_product(){
        $data = request(['id']);
        try {
            $_producto = Producto::findOrFail($data['id']);
            $_producto->delete();

            $response = ['result' => 'success','msg' => 'Eliminación exitosa'];
            return $response;

        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function reg_user(){
        $credentials = request(['nombre','primerApellido','segundoApellido','email','telefono',
            'celular', 'numero_personal', 'rfc', 'curp','password']);
        try {
            $user['name'] = trim($credentials['nombre']).' '.trim($credentials['primerApellido']).' '.trim($credentials['segundoApellido']);
            $user['email'] = trim($credentials['email']);
            $user['password'] = bcrypt(trim($credentials['password']));
            $_user = new User($user);
            $_user->save();

            $person['user_id'] = $_user['id'];
            $person['nombre'] = trim($credentials['nombre']);
            $person['primerApellido'] = trim($credentials['primerApellido']);
            $person['segundoApellido'] = trim($credentials['segundoApellido']);
            $person['email'] = trim($credentials['email']);
            $person['telefono'] = trim($credentials['telefono']);
            $person['celular'] = trim($credentials['celular']);
            $person['numero_personal'] = trim($credentials['numero_personal']);
            $person['rfc'] = trim($credentials['rfc']);
            $person['curp'] = trim($credentials['curp']);
            $_person = new Persona($person);
            $_person->save();

            $response = ['result' => 'success', 'msg' => 'Usuario completo agregado satisfactoriamente'];
            return $response;
        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function register()
    {
        $credentials = request(['name','email','password']);
        try {
            $user['name'] = trim($credentials['name']);
            $user['email'] = trim($credentials['email']);
            $user['password'] = bcrypt(trim($credentials['password']));
            $_user = new User($user);
            $_user->save();

            $response = ['result' => 'success', 'msg' => 'Usuario agregado satisfactoriamente'];
            return $response;

        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function show_users(){
        try{
            $user = User::all();
            for ($i=0; $i < count($user); $i++){
                $lista[] = ['user' => $user[$i],'persona' => $user[$i]->persona];
            }
            $response = ['result' => 'success','data' => $lista];
            return $response;
        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function show_user(){
        try{
            $identified = request(['id']);
            $user = User::findOrFail($identified['id']);
            $data = ['user' => $user, 'persona' => $user->persona];
            $response = ['result' => 'success','data' => $data];
            return $response;
        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function update_user(){
        $credentials = request(['id','nombre','primerApellido','segundoApellido','email','telefono',
            'celular', 'numero_personal', 'rfc', 'curp']);
        try {
            $user['name'] = trim($credentials['nombre']).' '.trim($credentials['primerApellido']).' '.trim($credentials['segundoApellido']);
            $user['email'] = trim($credentials['email']);
            $_user = User::findOrFail($credentials['id']);
            $_user->update($user);

            $person['user_id'] = $_user['id'];
            $person['nombre'] = trim($credentials['nombre']);
            $person['primerApellido'] = trim($credentials['primerApellido']);
            $person['segundoApellido'] = trim($credentials['segundoApellido']);
            $person['email'] = trim($credentials['email']);
            $person['telefono'] = trim($credentials['telefono']);
            $person['celular'] = trim($credentials['celular']);
            $person['numero_personal'] = trim($credentials['numero_personal']);
            $person['rfc'] = trim($credentials['rfc']);
            $person['curp'] = trim($credentials['curp']);
            $_person = Persona::findOrFail($_user->persona->id);
            $_person->update($person);

            $response = ['result' => 'success', 'msg' => 'Usuario modificado satisfactoriamente'];
            return $response;
        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function delete_user(){
        $data = request(['id']);
        try {

            $_user = User::findOrFail($data['id']);
            if ($_user->persona->id){
                $_persona = Persona::findOrFail($_user->persona->id);
                $_persona->delete();
            }
            $_user->delete();

            $response = ['result' => 'success','msg' => 'Eliminación exitosa'];
            return $response;

        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }

    public function fill_user(){
        $credentials = request(['user_id','nombre','primerApellido','segundoApellido','email','telefono',
            'celular', 'numero_personal', 'rfc', 'curp']);
        try {
            $user['name'] = trim($credentials['nombre']).' '.trim($credentials['primerApellido']).' '.trim($credentials['segundoApellido']);
            $user['email'] = trim($credentials['email']);
            $_user = User::findOrFail($credentials['user_id']);
            $_user->update($user);

            $person['user_id'] = trim($credentials['user_id']);
            $person['nombre'] = trim($credentials['nombre']);
            $person['primerApellido'] = trim($credentials['primerApellido']);
            $person['segundoApellido'] = trim($credentials['segundoApellido']);
            $person['email'] = trim($credentials['email']);
            $person['telefono'] = trim($credentials['telefono']);
            $person['celular'] = trim($credentials['celular']);
            $person['numero_personal'] = trim($credentials['numero_personal']);
            $person['rfc'] = trim($credentials['rfc']);
            $person['curp'] = trim($credentials['curp']);
            $_person = new Persona($person);
            $_person->save();

            $response = ['result' => 'success', 'msg' => 'Registro de usuario modificado satisfactoriamente'];
            return $response;
        } catch (\Exception $e) {
            $response = ['result' => 'error','msg' => $e];
            return $response;
        }catch (QueryException $ex){
            $response = ['result' => 'error','msg' => $ex];
            return $response;
        }
    }
}
