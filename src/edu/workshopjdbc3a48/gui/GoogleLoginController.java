import com.fasterxml.jackson.core.JsonParser;
import com.google.gson.JsonObject;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ResourceBundle;

import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.web.WebView;

public class GoogleLoginController implements Initializable {

    @FXML
    private WebView web;

    private static final String CLIENT_ID = "736433699384-oqc24v5501819t04jcpqblb3k5r4u44c.apps.googleusercontent.com";
    private static final String CLIENT_SECRET = "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";
    private static final String REDIRECT_URI = "urn:ietf:wg:oauth:2.0:oob";
    private static final String AUTHORIZATION_ENDPOINT = "https://accounts.google.com/o/oauth2/auth";
    private static final String TOKEN_ENDPOINT = "https://oauth2.googleapis.com/token";
    private static final String USERINFO_ENDPOINT = "https://www.googleapis.com/oauth2/v1/userinfo?alt=json";

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }

    public void loadGoogleLogin() {
        String authorizationUrl = AUTHORIZATION_ENDPOINT + "?response_type=code&client_id=" + CLIENT_ID +
                "&redirect_uri=" + REDIRECT_URI + "&scope=email%20profile";

        web.getEngine().load(authorizationUrl);

        web.getEngine().locationProperty().addListener(new ChangeListener<String>() {
            @Override
            public void changed(ObservableValue<? extends String> observable, String oldValue, String newValue) {
                if (newValue.startsWith(REDIRECT_URI)) {
                    // Extract the authorization code from the URL
                    String code = newValue.substring(newValue.indexOf("code=") + 5);

                    try {
                        // Exchange the authorization code for an access token
                        URL tokenUrl = new URL(TOKEN_ENDPOINT);
                        HttpURLConnection connection = (HttpURLConnection) tokenUrl.openConnection();
                        connection.setRequestMethod("POST");
                        connection.setDoOutput(true);

                        String requestBody = "code=" + code + "&client_id=" + CLIENT_ID + "&client_secret=" + CLIENT_SECRET +
                                "&redirect_uri=" + REDIRECT_URI + "&grant_type=authorization_code";
                        OutputStream outputStream = connection.getOutputStream();
                        outputStream.write(requestBody.getBytes());
                        outputStream.flush();
                        outputStream.close();

                        InputStream inputStream = connection.getInputStream();
                        BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
                        StringBuilder builder = new StringBuilder();
                        String line;

                        while ((line = reader.readLine()) != null) {
                            builder.append(line);
                        }

                        reader.close();
                        inputStream.close();

                        // Extract the access token from the response
                        JsonParser parser = new JsonParserFactory().createParser();
JsonObject response = parser.parse(builder.toString()).getAsJsonObject();
                        String accessToken = response.get("access_token").getAsString();

                        // Use the access token to make an authorized API request
                        URL userinfoUrl = new URL(USERINFO_ENDPOINT);
                        connection = (HttpURLConnection) userinfoUrl.openConnection();
                        connection.setRequestProperty("Authorization", "Bearer " + accessToken);

                        inputStream = connection.getInputStream();
                        reader = new BufferedReader(new InputStreamReader(inputStream));
                        builder = new StringBuilder();

                        while ((line = reader.readLine()) != null) {
                            builder.append(line);
                        }

                        reader.close();
                        inputStream.close();

                        // Extract the user's email from the response
                        JsonObject userInfoResponse = new JsonParser().parse(builder.toString()).getAsJsonObject();
                        String email = userInfoResponse.get("email").getAsString();
                        System.out.println("User email: " + email);

                    System.out.println("User email: " + email);
                } catch (MalformedURLException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }
    });
}
}