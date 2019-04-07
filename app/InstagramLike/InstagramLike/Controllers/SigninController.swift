//
//  SigninController.swift
//  InstagramLike
//
//  Created by Jonathan Meslien on 25/03/2019.
//  Copyright © 2019 Jonathan Meslien. All rights reserved.
//

import UIKit

class SigninController: UIViewController {
    
    @IBOutlet weak var Validate: UIButton!
    @IBOutlet weak var Password: UITextField!
    @IBOutlet weak var Email: UITextField!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        let gradientLayer = CAGradientLayer()
        gradientLayer.transform = CATransform3DMakeRotation(90.0 / 180.0 * .pi, 0, 0, 1)
        gradientLayer.frame = self.view.bounds
        gradientLayer.colors = [CustomOrange.cgColor, CustomPink.cgColor]
        self.view.layer.insertSublayer(gradientLayer, at: 0)
        self.Validate.backgroundColor = BLUE
        self.Email.placeholder = EMAIL_TEXT
        self.Password.placeholder = PASSWORD_TEXT
        let CallApi = RequestApi()
//        let urlencoded = CallApi.Register(email: <#T##String#>, password: <#T##String#>, username: <#T##String#>)
//        CallApi.getData(uri: "/auth/register", urlencoded: urlencoded) { (data, error) in
//            print(data as Any)
//        }
    }
}
    
    


