/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import edu.workshopjdbc3a48.services.UserSession;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author user
 */
public class VerficationcompteController implements Initializable {

    public VerficationcompteController() {
    }

    @FXML
    private TextField tfCode;
    @FXML
    private Button btnCode;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void Activer(ActionEvent event) throws IOException {
        Utilisateur u = UserSession.getInstance().getCurrentUser();
        if (u.getCode()==Integer.parseInt(tfCode.getText()))
        {
         ServiceUtilisateur su = new ServiceUtilisateur();
         su.ActiverUser(u);
          FXMLLoader loader = new FXMLLoader(getClass().getResource("Login.fxml"));
    Parent root = loader.load();

            
            
    Stage stage = new Stage();
    stage.setScene(new Scene(root));
    stage.show();
     Stage stage1;
            stage1 = (Stage) btnCode.getScene().getWindow();
        stage1.close();
    }
    else
        { Alert alert = new Alert(Alert.AlertType.INFORMATION);
alert.setTitle("Alerte");
alert.setHeaderText(null);
alert.setContentText("Code incorrect !");
alert.showAndWait();
        
        
        }
    
    
    
    
    }
    
}
