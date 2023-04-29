/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entity.Consultation;
import Entity.Local;
import Services.ServiceConsultation;
import Services.ServiceLocal;
import java.io.IOException;
import static java.lang.Integer.parseInt;
import java.net.URL;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.ZoneId;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.ComboBox;
import javafx.scene.control.DatePicker;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class AjouterConsultationController implements Initializable {
 

    @FXML
    private TextField nom_patient;
    @FXML
    private TextField nom_medecin;
    private TextField date;
    @FXML
    private TextField duree;
    private ComboBox<String> locaux;
    @FXML
    private DatePicker inputdate;


    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
    }    

    @FXML
    private void ajouter_consultation(ActionEvent event) throws IOException {

     ServiceConsultation sc = new ServiceConsultation();
        Consultation c = new Consultation();
          String a = nom_patient.getText() ;
        String b = nom_medecin.getText() ;
       

        int d = Integer.parseInt(duree.getText()) ;
        
         if ( a.isEmpty() || b.isEmpty()   || duree.getText().isEmpty()  ){
        JOptionPane.showMessageDialog(null, " champs obligatoire !");
        return ;
        }
           
             if (inputdate.getValue()==null){
          JOptionPane.showMessageDialog(null, "Date can't be empty");
     }
         if ( !a.chars().allMatch(Character::isLetter) || 
    !b.chars().allMatch(Character::isLetter) ) {
    JOptionPane.showMessageDialog(null, "Veuillez remplir tous les champs avec des lettres uniquement!");
    return;
}

        LocalDate currentDate = inputdate.getValue();
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
        String dateString = currentDate.format(formatter);
        DateFormat inputFormat = new SimpleDateFormat("EEE MMM dd HH:mm:ss zzz yyyy");
        try {
            Date date = inputFormat.parse(dateString);
            DateFormat outputFormat = new SimpleDateFormat("yyyy-MM-dd");
            String formattedDate = outputFormat.format(date);
            Date dates = outputFormat.parse(dateString);
        
    c.setNom_patient(a);
    c.setNom_medecin(b);
    c.setDuree(d);
    c.setDate(dates);
 
sc.add(c);        } catch (ParseException e) {
            System.out.println("Error parsing date: " + e.getMessage());
        }


        
    }

    

    
 




}
