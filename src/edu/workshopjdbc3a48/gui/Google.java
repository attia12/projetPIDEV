package edu.workshopjdbc3a48.gui;
import com.google.api.client.auth.oauth2.AuthorizationCodeFlow;
import com.google.api.client.auth.oauth2.AuthorizationCodeRequestUrl;
import com.google.api.client.auth.oauth2.AuthorizationCodeTokenRequest;
import com.google.api.client.auth.oauth2.Credential;
import com.google.api.client.extensions.java6.auth.oauth2.AuthorizationCodeInstalledApp;
import com.google.api.client.extensions.jetty.auth.oauth2.LocalServerReceiver;
import com.google.api.client.googleapis.auth.oauth2.GoogleAuthorizationCodeFlow;
import com.google.api.client.googleapis.auth.oauth2.GoogleClientSecrets;
import com.google.api.client.googleapis.javanet.GoogleNetHttpTransport;
import com.google.api.client.json.jackson2.JacksonFactory;
import com.google.api.services.oauth2.Oauth2;
import com.google.api.services.oauth2.Oauth2Scopes;
import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.gui.AffichageUser;
import edu.workshopjdbc3a48.gui.AfficherUserController;
import edu.workshopjdbc3a48.gui.ModifierUserController;
import edu.workshopjdbc3a48.services.UserSession;
import javafx.application.Application;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;

import java.io.*;
import java.security.GeneralSecurityException;
import java.util.Arrays;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;

public class Google extends Application {

    private static final String CLIENT_SECRETS_FILE = "‪C:/code.json";
    private static final List<String> SCOPES = Arrays.asList(Oauth2Scopes.USERINFO_EMAIL, Oauth2Scopes.USERINFO_PROFILE);
    private static final String REDIRECT_URI = "urn:ietf:wg:oauth:2.0:oob";
    private static final JacksonFactory JSON_FACTORY = JacksonFactory.getDefaultInstance();

    public static void main(String[] args) {
        launch(args);
    }

    @Override
    public void start(Stage primaryStage) throws Exception {
        Button loginButton = new Button("Log in with Google");
        loginButton.setOnAction(event -> {
            try {
                performOAuth2();
            } catch (Exception e) {
                e.printStackTrace();
            }
        });

        VBox root = new VBox(loginButton);
        Scene scene = new Scene(root, 300, 250);

        primaryStage.setTitle("Google Login Demo");
        primaryStage.setScene(scene);
        primaryStage.show();
    }

    void performOAuth2() throws GeneralSecurityException, IOException {
        GoogleClientSecrets clientSecrets = loadClientSecrets();
        AuthorizationCodeFlow flow = new GoogleAuthorizationCodeFlow.Builder(
                GoogleNetHttpTransport.newTrustedTransport(),
                JSON_FACTORY,
                clientSecrets,
                SCOPES)
                .build();

        LocalServerReceiver receiver = new LocalServerReceiver.Builder().setPort(8888).build();
        Credential credential = new AuthorizationCodeInstalledApp(flow, receiver).authorize("user");

        Oauth2 oauth2 = new Oauth2.Builder(GoogleNetHttpTransport.newTrustedTransport(), JSON_FACTORY, credential)
                .setApplicationName("Google Login Demo")
                .build();
Utilisateur u = new Utilisateur();
        u.setEmail(oauth2.userinfo().get().execute().getEmail());
        u.setNom(oauth2.userinfo().get().execute().getGivenName());
        u.setPrenom(oauth2.userinfo().get().execute().getFamilyName());
       
       u.setImg(oauth2.userinfo().get().execute().getPicture());
         UserSession.getInstance().setCurrentUser(u);
        FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherUser.fxml"));
            Parent root = null;
           
                root = loader.load();
            
           
           
           
            Scene scene = new Scene(root);
            Stage stage1 = new Stage();
            stage1.setScene(scene);
          stage1.show();
          
             
    }

    private GoogleClientSecrets loadClientSecrets() throws IOException {
       String filePath = "C:/code.json";
    InputStream inputStream = new FileInputStream(filePath);
    System.out.println(inputStream);
    InputStreamReader reader = new InputStreamReader(inputStream);
    return GoogleClientSecrets.load(JSON_FACTORY, reader);
    }
}