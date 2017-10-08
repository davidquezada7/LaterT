package edu.galileo.android.myapplication;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

public class Principal extends AppCompatActivity {
    String json_string;
    Button btnIniciar;
    Button btnActualizar;
    Button btnToken;
    String url = "http://www.latert.net/register.php";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_principal);

        btnIniciar = (Button) findViewById(R.id.btnIniciar);
        btnActualizar = (Button) findViewById(R.id.btnActualizar);
        btnToken = (Button) findViewById(R.id.btnToken);

        btnIniciar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (json_string==null){
                    Toast.makeText(getApplicationContext(),"Esperando",Toast.LENGTH_LONG).show();
                }else{
                    Intent intent = new Intent(Principal.this, MainActivity.class);
                    intent.putExtra("json_data",json_string);
                    startActivity(intent);
                }
            }
        });

        btnActualizar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new BackgroundTask().execute();
            }
        });

        btnToken.setOnClickListener(new View.OnClickListener(){

            @Override
            public void onClick(View v) {
                SharedPreferences sharedPreferences = getApplicationContext().getSharedPreferences(getString(R.string.FCM_PREF), Context.MODE_PRIVATE);
                final String token = sharedPreferences.getString(getString(R.string.FCM_TOKEN),"");
                System.out.println("token :->"+token);

                StringRequest stringRequest = new StringRequest(Request.Method.POST,url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {

                            }
                        }, new Response.ErrorListener(){
                    @Override
                    public void onErrorResponse(VolleyError error) {

                    }
                }
                )
                {
                    @Override
                    protected Map<String, String> getParams() throws AuthFailureError {
                        Map<String, String> params = new HashMap<String, String>();
                        params.put("fcm_token",token);
                        return params;
                    }
                };
                MySingleton.getmInstance(Principal.this).addToRequestQueue(stringRequest);
            }
        });
    }

    class BackgroundTask extends AsyncTask<Void,Void,String> {
        String json_url;
        String JSON_STRING;
        @Override
        protected void onPreExecute() {
            json_url = "http://www.latert.net/webservice/alert.php";
        }

        @Override
        protected String doInBackground(Void... params) {
            try {
                URL url = new URL(json_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
                StringBuilder stringBuilder = new StringBuilder();
                while((JSON_STRING = bufferedReader.readLine()) != null){
                    stringBuilder.append(JSON_STRING+"\n");
                }


                bufferedReader.close();
                inputStream.close();
                httpURLConnection.disconnect();

                return stringBuilder.toString().trim();

            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return null;
        }

        @Override
        protected void onProgressUpdate(Void... values) {
            super.onProgressUpdate(values);
        }

        @Override
        protected void onPostExecute(String  result) {
            //TextView textView = (TextView) findViewById(R.id.textview);
            //textView.setText(result);
            json_string = result;
        }
    }
}
