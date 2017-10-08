package edu.galileo.android.myapplication;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.List;

public class Main2Activity extends AppCompatActivity {
    Button btnMapa;
    ListView listadetalles;
    String placa = null;
    String propietario = null;
    String marca = null;
    String color = null;
    String modelo = null;
    String motivo = null;
    String latitud = null;
    String longitud = null;
    String direccion = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main2);
        listadetalles = (ListView) findViewById(R.id.detalles);

        Bundle bundle = getIntent().getExtras();
        placa = bundle.getString("placa").toString();
        propietario = bundle.getString("propietario").toString();
        marca = bundle.getString("marca").toString();
        color = bundle.getString("color").toString();
        modelo = bundle.getString("modelo").toString();
        motivo = bundle.getString("motivo").toString();
        latitud = bundle.getString("lat").toString();
        longitud = bundle.getString("lng").toString();
        direccion = bundle.getString("direccion").toString();

        ArrayList lista = new ArrayList();
        lista.add("Placa:   "+placa);
        lista.add("Propietario: "+propietario);
        lista.add("Marca: " + marca);
        lista.add("Color: " + color);
        lista.add("Modelo: "+ modelo);
        lista.add("Motivo: "+motivo);
        lista.add("Direccion: "+direccion);

        ArrayAdapter adaptadorLista = new ArrayAdapter(this,android.R.layout.simple_list_item_1, lista);
        listadetalles.setAdapter(adaptadorLista);

        btnMapa = (Button) findViewById(R.id.btnMapa);
        btnMapa.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String lat = latitud;
                String lng = longitud;

                Intent intent = new Intent(Main2Activity.this, MapsActivity.class);
                intent.putExtra("lat",lat);
                intent.putExtra("lng",lng);

                startActivity(intent);
            }
        });

    }
}
