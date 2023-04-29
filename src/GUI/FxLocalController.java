/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entity.Local;
import Services.ServiceLocal;
import com.jfoenix.controls.JFXButton;
import com.jfoenix.controls.JFXTextField;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.input.MouseEvent;
import javax.swing.JOptionPane;
import ressources.Util;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class FxLocalController implements Initializable {

    @FXML
    private JFXTextField blockName;
    @FXML
    private JFXTextField patientName;
    @FXML
    private JFXTextField MedName;
    @FXML
    private JFXTextField Location;
    @FXML
    private JFXButton AddImage;
    private String res;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

        
    @FXML
    private void choosefile(ActionEvent event) {
        Util u = new Util();
        res =  u.ImgPicker () ;
        System.out.println(res);


    }
    @FXML
    private void AddL(ActionEvent event) {
                ServiceLocal sp = new ServiceLocal();
        EventHandler<MouseEvent> Cfile = new EventHandler<MouseEvent> (){
        
            public void handle(MouseEvent e) {
       Util u = new Util();
        res =  u.ImgPicker () ;
                System.out.println("res is" + res);

            }};
        AddImage.setOnMouseClicked(Cfile);    
                String pi1 =   res ;

                String a = blockName.getText() ;
        String b = patientName.getText() ;
        String c = MedName.getText() ;
        String d = Location.getText() ;
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
         res = res.replace("\\", "\\\\");
        System.out.println(a + b + c + d + res);
        sp.add(new Local(a,b,c,d,res));
        
        JOptionPane.showMessageDialog(null, "local ajoutée !");
       
    }


    
}
