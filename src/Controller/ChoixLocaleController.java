/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Label;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class ChoixLocaleController implements Initializable {

    @FXML
    private Label aa;
    @FXML
    private Label aa1;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void ajouter(ActionEvent event) throws IOException {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("AjouterLocale.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
    }

    @FXML
    private void modifier(ActionEvent event) throws IOException {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("ModifierLocale.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
    }

    @FXML
    private void afficher(ActionEvent event) throws IOException {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherLocale.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
    }

    @FXML
    private void supprimer(ActionEvent event) throws IOException {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("SupprimerLocale.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
    }
     @FXML
    private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("Bienvenue.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
    }
    
}
