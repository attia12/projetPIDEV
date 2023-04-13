/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import Entity.Local;
import Services.ServiceLocal;
import java.io.IOException;
import java.net.URL;
import java.util.Locale;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javax.swing.JOptionPane;


/**
 * FXML Controller class
 *
 * @author donia
 */
public class AjouterLocaleController implements Initializable {

    @FXML
    private TextField nom_bloc;
    @FXML
    private TextField nom_patient;
    @FXML
    private TextField nom_medecin;
    @FXML
    private TextField localisation;
    @FXML
    private Label aa;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void ajouter_locale(ActionEvent event) throws IOException {
        ServiceLocal sp = new ServiceLocal();
 
                String a = nom_bloc.getText() ;
        String b = nom_patient.getText() ;
        String c = nom_medecin.getText() ;
        String d = localisation.getText() ;
         if ( a.isEmpty() || b.isEmpty()  || c.isEmpty() || d.isEmpty()  ){
        JOptionPane.showMessageDialog(null, " champs obligatoire !");
        return ;
        }
         if ( !a.chars().allMatch(Character::isLetter) || 
    !b.chars().allMatch(Character::isLetter) || 
  c.isEmpty() || d.isEmpty()) {
    JOptionPane.showMessageDialog(null, "Veuillez remplir tous les champs avec des lettres uniquement!");
    return;
}

        sp.add(new Local(nom_bloc.getText(),nom_patient.getText(),nom_medecin.getText(),localisation.getText()));
        
        JOptionPane.showMessageDialog(null, "local ajoutée !");
       
        FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherLocale.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
        AfficherLocaleController dpc = loader.getController();
        
        dpc.setLbnom_bloc(nom_bloc.getText());
        dpc.setLbnom_patient(nom_patient.getText());
        dpc.setLbnom_medecin(nom_medecin.getText());
        dpc.setLblocalisation(localisation.getText());
        
        
    }
    
     @FXML
    private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixLocale.fxml"));
        Parent root = loader.load();
        localisation.getScene().setRoot(root);
    }
    
}
