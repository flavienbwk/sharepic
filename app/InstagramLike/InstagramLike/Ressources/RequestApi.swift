//
//  RequestApi.swift
//  InstagramLike
//
//  Created by Jonathan Meslien on 05/04/2019.
//  Copyright © 2019 Jonathan Meslien. All rights reserved.
//

import Foundation


class RequestApi {
    let Uri: String = "https://sharepic.berwick.fr/api"
    
    func getData(uri: String, urlencoded: String, userCompletionHandler: @escaping (NSDictionary?, Error?) -> Void) {
        let url = URL(string: self.Uri + uri)!
        var request = URLRequest(url: url)
        request.setValue("application/x-www-form-urlencoded", forHTTPHeaderField: "Content-Type")
        request.httpMethod = "POST"
        let postString = urlencoded
        request.httpBody = postString.data(using: .utf8)
        let task = URLSession.shared.dataTask(with: request, completionHandler: { data, response, error in
            guard let data = data, error == nil else {
                print(error?.localizedDescription ?? "No data")
                return
            }
            do {
                let jsonResponse = try JSONSerialization.jsonObject(with: data, options: JSONSerialization.ReadingOptions()) as? NSDictionary
                 userCompletionHandler(jsonResponse, nil)
            }catch {
                print("JSONSerialization error:", error)
                userCompletionHandler(nil, error)
            }
        })
        task.resume()
    }
    
    func Register(email: String, password: String, username: String) -> String{
        return "email="+email+"&password="+password+"&username="+username
    }
    
    func Login(username: String, password: String) -> String {
        return "username="+username+"&password="+password
    }
    
}

