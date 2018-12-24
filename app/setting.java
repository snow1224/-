package anbas.second_app;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.view.KeyEvent;
import android.view.View.OnKeyListener;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;
import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;

public class SettingAct extends AppCompatActivity  implements View.OnClickListener{
    private Button btOk,btpre,btnext,btdel,btrewrite;
    private EditText etPlantName;
    private EditText etWet;
    private EditText etRange;
    private TextView tvPage;
    public int flag=0,optional=2; //optional選擇第幾個選項，因為操作指令不同，預設為修改
    String result,account,passwd,plant_wetdata;
    int ptid,page=0;
    String plant_data;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_setting);
        buildViews();
    }

    private void buildViews(){
        etPlantName = (EditText) findViewById(R.id.etIdName);
        etWet = (EditText) findViewById(R.id.etIdWet);
        etRange = (EditText) findViewById(R.id.etIdRange);
        etWet.setOnKeyListener(kyListener);
        etRange.setOnKeyListener(kyListener);
        btOk = (Button)findViewById(R.id.btIdOk);
        btnext=(Button)findViewById(R.id.btIdnext);
        btpre=(Button)findViewById(R.id.btIdpre);
        btdel=(Button)findViewById(R.id.btIdDel);
        btrewrite=(Button)findViewById(R.id.btIdRewrite);
        tvPage=(TextView)findViewById(R.id.tvIdPage);
        btOk.setOnClickListener(this);
        btnext.setOnClickListener(this);
        btpre.setOnClickListener(this);
        btdel.setOnClickListener(this);
        btrewrite.setOnClickListener(this);
        tvPage.setText("頁數: 1/1");
        try {

            Bundle bundle = getIntent().getExtras();
            result = bundle.getString("jsonData");
            account = bundle.getString("account");
            passwd = bundle.getString("password");
            plant_data = bundle.getString("ptData");
            Toast.makeText(SettingAct.this,plant_data,Toast.LENGTH_SHORT);
            JSONArray jsonArray = new JSONArray(plant_data);
            ptid=jsonArray.length();
            JSONObject data = jsonArray.getJSONObject(page);
            etPlantName.setText(data.getString("plant_name"));
            Double changeWet = Double.valueOf(data.getString("Humidity_standard"));
            Double changeRange = Double.valueOf(data.getString("Humidity_standard_range"));

            etWet.setText(changeWet.toString());
            etRange.setText(changeRange.toString());
            tvPage.setText("頁數: "+(page+1)+"/"+jsonArray.length());
        }catch(Exception e){
            result = "fail2";
        }
    }
    private OnKeyListener kyListener = new OnKeyListener(){
        public boolean onKey(View v,int keyCode,KeyEvent event){
            String stWet = etWet.getText().toString();
            String stRange = etRange.getText().toString();
            if(event.getAction()==KeyEvent.ACTION_DOWN && keyCode == KeyEvent.KEYCODE_ENTER){
                try{
                    int wet = Integer.valueOf(stWet);
                    int range = Integer.valueOf(stRange);
                    Toast.makeText(SettingAct.this,"wet:"+wet,Toast.LENGTH_SHORT);
                    return true;
                }
                catch(Exception e){
                    Toast.makeText(SettingAct.this,"輸入錯誤，請重新輸入數值！",Toast.LENGTH_SHORT);
                 //   flag=1;
                    return true;
                }
            }else
                return false;

        }
    };
    public void onClick(View v) {
        CharSequence csName = etPlantName.getText();
        CharSequence csWet = etWet.getText();
        CharSequence csRange = etRange.getText();
        Intent intent = new Intent();
        Bundle bundle = new Bundle();

        switch (v.getId()) {
            case R.id.btIdOk:   // 新增
                try {
                    intent.setClass(SettingAct.this, SetSuccAct.class);
                    bundle.putString("name", csName.toString());
                    bundle.putString("wet", csWet.toString());
                    bundle.putString("range", csRange.toString());
                    bundle.putString("jsonData", result);
                    bundle.putString("account", account);
                    bundle.putString("password", passwd);
                    ptid += 1;
                    Double wet = Double.valueOf(csWet.toString());
                    Double range = Double.valueOf(csRange.toString());
                    String qst = "INSERT INTO `plant_rec2` (`plant_ID_number`,`plant_name`,`Humidity_standard`,`Humidity_standard_range`,`account`)" +
                            " VALUES ('" + ptid + "','" + csName.toString() + "','" + wet + "','" + range + "','" + account + "')";
                    String add = executeQuery(qst);
                    plant_data = executeQuery("SELECT * FROM `plant_rec2` WHERE `account`='"+account+"'");

                    JSONArray jsonArray = new JSONArray(plant_data);
                    int page = 0;
                    JSONObject data = jsonArray.getJSONObject(page);
                    String plant_id = data.getString("plant_ID_number");
//                    Integer int_plant_id = Integer.valueOf(plant_id);

                    plant_wetdata = executeQuery("SELECT * FROM `humidity_rec` WHERE `plant_ID_number`='" + plant_id + "'");
                //    Toast.makeText(SettingAct.this, plant_wetdata, Toast.LENGTH_SHORT).show();
                    bundle.putString("A_plant_wetdata",plant_wetdata);

                    bundle.putString("ptData", plant_data);
                    intent.putExtras(bundle);
                    Toast.makeText(SettingAct.this, "新增成功！", Toast.LENGTH_SHORT).show();
                    intent.setClass(SettingAct.this, ViewStatus.class);
                    startActivity(intent);
                    finish();
                }catch(Exception e){}
                break;
            case R.id.btIdDel:
                try {
                    JSONArray jsonArray = new JSONArray(plant_data);
                    JSONObject data = jsonArray.getJSONObject(page);
                    int id = data.getInt("plant_ID_number");
                    String qst2 = "DELETE FROM `plant_rec2` WHERE `plant_ID_number`=" + id;
                    String del = executeQuery(qst2);
                    Toast.makeText(SettingAct.this, "刪除成功！", Toast.LENGTH_SHORT).show();
                    plant_data = executeQuery("SELECT * FROM plant_rec2");

                    String plant_id = data.getString("plant_ID_number");
                    plant_wetdata = executeQuery("SELECT * FROM `humidity_rec` WHERE `plant_ID_number`='" + plant_id + "'");
                //    Toast.makeText(SettingAct.this, plant_wetdata, Toast.LENGTH_SHORT).show();
                    bundle.putString("A_plant_wetdata",plant_wetdata);

                    bundle.putString("jsonData", result);
                    bundle.putString("account", account);
                    bundle.putString("password", passwd);
                    bundle.putString("ptData", plant_data);
                    intent.putExtras(bundle);
                    intent.setClass(SettingAct.this, ViewStatus.class);
                    startActivity(intent);
                    finish();
                }catch(Exception e){
                    Toast.makeText(SettingAct.this, "Error！", Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.btIdRewrite:
                try {
                    JSONArray jsonArray = new JSONArray(plant_data);
                    JSONObject data = jsonArray.getJSONObject(page);
                    int id = data.getInt("plant_ID_number");
                    String stPtName = etPlantName.getText().toString(), stWet = etWet.getText().toString();
                    String stRange = etRange.getText().toString();
                    String rewriteData = executeQuery("UPDATE `plant_rec2` SET `plant_name`='" + stPtName + "'" +
                            ",`Humidity_standard`=" + stWet + ",`Humidity_standard_range`=" + stRange + " WHERE `plant_ID_number`=" + id);
                //    Toast.makeText(SettingAct.this, "修改成功！", Toast.LENGTH_SHORT).show();
                    result = executeQuery("SELECT * FROM account_rec");
                    plant_data = executeQuery("SELECT * FROM plant_rec2 WHERE `account`='"+account+"'");

                    String plant_id = data.getString("plant_ID_number");
//                    Integer int_plant_id = Integer.valueOf(plant_id);

                    plant_wetdata = executeQuery("SELECT * FROM `humidity_rec` WHERE `plant_ID_number`='" + plant_id + "'");
                    bundle.putString("A_plant_wetdata",plant_wetdata);

                    bundle.putString("jsonData", result);
                    bundle.putString("account", account);
                    bundle.putString("password", passwd);
                    bundle.putString("ptData", plant_data);
                    intent.putExtras(bundle);
                    intent.setClass(SettingAct.this, ViewStatus.class);
                    startActivity(intent);
                    finish();
                }
                catch (Exception e){
                    Toast.makeText(SettingAct.this, "Error！", Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.btIdnext:
                page++;
                try {
                    JSONArray jsonArray = new JSONArray(plant_data);
                    JSONObject data = jsonArray.getJSONObject(page);
                    String chWet=data.getString("Humidity_standard");
                    String chRange=data.getString("Humidity_standard_range");
                    Double changeWet = Double.valueOf(chWet);
                    Double changeRange = Double.valueOf(chRange);
                    etPlantName.setText(data.getString("plant_name"));
                    etWet.setText(changeWet.toString());
                    etRange.setText(changeRange.toString());
                    tvPage.setText("頁數: "+(page+1)+"/"+jsonArray.length());
                }
                catch(Exception e){
                    Toast.makeText(SettingAct.this, "沒有下筆資料了！", Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.btIdpre:
                page--;
                try {
                    JSONArray jsonArray = new JSONArray(plant_data);
                    JSONObject data = jsonArray.getJSONObject(page);
                    String chWet=data.getString("Humidity_standard");
                    String chRange=data.getString("Humidity_standard_range");
                    Double changeWet = Double.valueOf(chWet);
                    Double changeRange = Double.valueOf(chRange);
                    etPlantName.setText(data.getString("plant_name"));
                    etWet.setText(changeWet.toString());
                    etRange.setText(changeRange.toString());
                    tvPage.setText("頁數: "+(page+1)+"/"+jsonArray.length());
                }
                catch(Exception e){
                    Toast.makeText(SettingAct.this, "資料已經到置頂了！", Toast.LENGTH_SHORT).show();
                }
                break;
            default:
                Toast.makeText(SettingAct.this, "輸入錯誤，請重新輸入數值！", Toast.LENGTH_SHORT);
                break;
        }
    }
    /////功能菜單///////
    public boolean onCreateOptionsMenu(Menu menu){
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu,menu);
        return true;
    }
    public boolean onOptionsItemSelected(MenuItem item){
        Intent intent = new Intent();
        Bundle bundle = new Bundle();
        switch(item.getItemId()){
            case R.id.tvLogout:
                intent.setClass(SettingAct.this, LogoutAct.class);
                startActivity(intent);
                finish();
                break;
            case R.id.itHistory:
                bundle.putString("jsonData",result);
                bundle.putString("account",account);
                bundle.putString("password",passwd);
                bundle.putString("ptData",plant_data);
                intent.putExtras(bundle);
                intent.setClass(SettingAct.this, HistoryRecord.class);
                startActivity(intent);
                finish();
                break;
            case R.id.itSetPlant:
                break;
            case R.id.itSetAccount:
                bundle.putString("jsonData",result);
                bundle.putString("account",account);
                bundle.putString("password",passwd);
                bundle.putString("ptData",plant_data);
                intent.putExtras(bundle);
                intent.setClass(SettingAct.this, SettedAccount.class);
                startActivity(intent);
                finish();
                break;
            case R.id.tvView:
                bundle.putString("jsonData",result);
                bundle.putString("account",account);
                bundle.putString("password",passwd);
                bundle.putString("ptData",plant_data);
                intent.putExtras(bundle);
                intent.setClass(SettingAct.this, ViewStatus.class);
                startActivity(intent);
                finish();
                break;
        }
        return true;
    }
    /////功能菜單///////
    public String executeQuery(String query_string) {  //String query_string
        String result = "";
        try {
            HttpClient httpClient = new DefaultHttpClient();
            HttpPost httpPost = new HttpPost("http://120.110.112.177:8321/catchv3_ssw.php");
            ArrayList<NameValuePair> params = new ArrayList<NameValuePair>();
            params.add(new BasicNameValuePair("query_string", query_string));
            httpPost.setEntity(new UrlEncodedFormEntity(params, HTTP.UTF_8));
            HttpResponse httpResponse = httpClient.execute(httpPost);
            HttpEntity httpEntity = httpResponse.getEntity();
            InputStream inputStream = httpEntity.getContent();
            BufferedReader bufReader = new BufferedReader(new InputStreamReader(inputStream, "utf-8"), 8);
            StringBuilder builder = new StringBuilder();
            String line = null;
            while((line = bufReader.readLine()) != null) {
                builder.append(line + "\n");
            }
            inputStream.close();
            result = builder.toString();
        } catch(Exception e) {

        }
        return result;
    }
}
