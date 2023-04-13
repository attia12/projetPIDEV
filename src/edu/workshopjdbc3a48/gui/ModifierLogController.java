/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Log;
import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.ServiceLog;
import java.net.URL;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author user
 */
public class ModifierLogController implements Initializable {
String s;
private Log us;
private LogsController firstInterface;
    @FXML
    private DatePicker date_lo;
    @FXML
    private Button btn_m;
    @FXML
    private TextField nom_lo;
public void setFirstInterface(LogsController firstInterface) {
        this.firstInterface = firstInterface;
    }
    public Log getUs() {
        return us;
    }
     public void setUs(Log us) {
        this.us = us;
        nom_lo.setText(us.getNom());
         DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
         LocalDate date = LocalDate.parse(us.getDate(), formatter);
        date_lo.setValue(date);
       
       
    }
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void mod_log(ActionEvent event) {
        ServiceLog sl = new ServiceLog();
        Log l=new Log();
        l.setId_log(us.getId_log());
        l.setId_user(us.getId_user());
        l.setType(us.getType());
        l.setDate(date_lo.getValue().toString());
        l.setNom(nom_lo.getText());
        System.out.println(l);

        sl.modifier(l);

firstInterface.update();
    
    Stage stage = (Stage) btn_m.getScene().getWindow();
    stage.close();   
 
    }
    
}
    

