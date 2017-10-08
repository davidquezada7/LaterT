package edu.galileo.android.myapplication;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {
    ListView listaplacas;
    String json_string;
    JSONObject jsonObject;
    JSONArray jsonArray;
    String[] placas;
    String[] propietarios;
    String[] marcas;
    String[] colores;
    String[] modelos;
    String[] motivos;
    String[] lat;
    String[] lng;
    String[] direcciones;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        listaplacas = (ListView) findViewById(R.id.listview1);
        ArrayList lista = new ArrayList();
        json_string = getIntent().getExtras().getString("json_data");
        try {
            jsonObject = new JSONObject(json_string);
            jsonArray = jsonObject.getJSONArray("server_response");
            int count = 0;
            placas = new String[jsonArray.length()];
            propietarios = new String[jsonArray.length()];
            marcas = new String[jsonArray.length()];
            colores = new String[jsonArray.length()];
            modelos = new String[jsonArray.length()];
            motivos = new String[jsonArray.length()];
            lat = new String[jsonArray.length()];
            lng = new String[jsonArray.length()];
            direcciones = new String[jsonArray.length()];

            String placa, fecha;
            while(count<jsonArray.length()){
                JSONObject JO = jsonArray.getJSONObject(count);

                placas[count] = JO.getString("placa");
                propietarios[count] = JO.getString("propietario");
                marcas[count] = JO.getString("marca");
                colores[count] = JO.getString("color");
                modelos[count] = JO.getString("modelo");
                motivos[count] = JO.getString("motivo");
                lat[count] = JO.getString("lat");
                lng[count] = JO.getString("lng");
                direcciones[count] = JO.getString("direccion");

                placa = JO.getString("placa");
                fecha= JO.getString("fecha");
                lista.add(placa + " - " + fecha);
                count++;
            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

        ArrayAdapter adaptadorLista = new ArrayAdapter(this,android.R.layout.simple_list_item_1, lista);
        //ArrayAdapter<CharSequence> adaptador = ArrayAdapter.createFromResource(this,R.array.listado,android.R.layout.simple_list_item_checked);
        listaplacas.setAdapter(adaptadorLista);



        listaplacas.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {


                    Intent intent = new Intent(MainActivity.this,Main2Activity.class);
                    intent.putExtra("placa",placas[position]);
                    intent.putExtra("propietario",propietarios[position]);
                    intent.putExtra("marca",marcas[position]);
                    intent.putExtra("color",colores[position]);
                    intent.putExtra("modelo",modelos[position]);
                    intent.putExtra("motivo",motivos[position]);
                    intent.putExtra("lat",lat[position]);
                    intent.putExtra("lng",lng[position]);
                    intent.putExtra("direccion",direcciones[position]);
                    startActivity(intent);


            }
        });

    }
}
