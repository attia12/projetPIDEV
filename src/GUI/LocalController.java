/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entity.Local;
import Services.ServiceLocal;
import java.net.URL;
import java.util.List;
import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ListView;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.scene.text.Text;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class LocalController implements Initializable {

    @FXML
    private AnchorPane lst;
    @FXML
    private TextField nom_block;
    @FXML
    private Text Nom;
    @FXML
    private TextField nom_patient;
    @FXML
    private TextField nom_medecin;
    @FXML
    private TextField localisation;
    @FXML
    private Button btnView;
    @FXML
    private Button btnADD;
    @FXML
    private Button btnDelete;
    @FXML
    private Button btnUpdate;
    @FXML
    private ListView<Local> v_event;
    @FXML
    private TextField tRecherche;
    @FXML
    private Button rech;
    @FXML
    private Button dashBtn;
    @FXML
    private Button eventBtn;
    @FXML
    private Button PartBtn;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    


    @FXML
    private void supprimerEvenement(ActionEvent event) {
    }

    @FXML
    private void modifierEvenement(ActionEvent event) {
    }

    @FXML
    private void recherche(ActionEvent event) {
    }

    @FXML
    private void dashboard(ActionEvent event) {
    }

    @FXML
    private void evenment(ActionEvent event) {
    }

    @FXML
    private void participation(ActionEvent event) {
    }

    @FXML
    private void afficher() {
          ServiceLocal V_Service = new ServiceLocal();
        List<Local> local = V_Service.afficher();
        ObservableList<Local> items = FXCollections.observableArrayList() ;
        for(Local evnt : local){
            items.add(evnt);
        }
       v_event.setItems(items);
         
    }

    @FXML
    private void ajouter(ActionEvent event) {
        ServiceLocal V_Service = new ServiceLocal();
        Local e = new Local();
            

          
            e.setNom_block(nom_block.getText());
             e.setNom_patient(nom_patient.getText());
              e.setNom_medecin(nom_medecin.getText());
               e.setLocalisation(localisation.getText());
            
            
            try {
                V_Service.add(e);
                Alert alert = new Alert(Alert.AlertType.INFORMATION);
                alert.setTitle("Information");
                alert.setHeaderText(null);
                alert.setContentText("L'event a été ajouté avec succès !");
                alert.show();
                
            } catch (Exception t) {
                Alert alert = new Alert(Alert.AlertType.ERROR);
                alert.setTitle("Erreur");
                alert.setHeaderText(null);
                alert.setContentText("Une erreur est survenue lors de l'ajout event : " + t.getMessage());
                alert.show();
            }
         afficher();
        
        
        
        
    }
    
}
